<?php

namespace App\Http\Controllers\Api\Distributor;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Distributor\TransferToMerchantRequest;
use App\Http\Resources\Api\Distributor\HomeResource;
use App\Http\Resources\Api\Distributor\MerchantDetailsResource;
use App\Http\Resources\Api\Distributor\MerchantTransactionsResource;
use App\Models\Distributor;
use App\Models\DistributorIndebtedness;
use App\Models\Merchant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Transfers\Entities\Transfer;
use PDF;

class HomeController extends Controller
{
    //
    public $user;
    public function __construct()
    {
        $this->user = auth()->guard('api_distributor')->user();
    }
    public function home(Request $request){
       $merchants =  Merchant::where('distributor_id',$this->user->id)
           ->orderBy('id','desc');
        if ($request->search){
            $merchants = $merchants->Where(function ($q) use($request){
                $q->where('name', 'LIKE', "%$request->search%");
                $q->orWhere('id', '=', $request->search);
            });
        }
        $merchants = $merchants->paginate(20);
        $merchants->getCollection()->transform(function ($data) {
            $data->is_inactive = $data->last_login_at === null ||
                Carbon::parse($data->last_login_at)->lt(now()->subDays(7));
            return $data;
        });
        HomeResource::collection($merchants);

        return ApiController::respondWithSuccess($merchants);

    }
    public function merchant_details(Request $request , $id){
       $merchant =  Merchant::where('distributor_id',$this->user->id)
            ->where('id',$id)
            ->first();
       if (!$merchant){
           return ApiController::respondWithServerError();
        }


       $data = new MerchantDetailsResource($merchant,$request);

        return ApiController::respondWithSuccess($data);

    }
    public function all_merchant_transaction(Request $request ,$id){
       $merchant =  Merchant::where('distributor_id',$this->user->id)
            ->where('id',$id)
            ->first();
       if (!$merchant){
           return ApiController::respondWithServerError();
        }
        $merchant =$merchant->userable()->Order()->where('providerable_type','App\Models\Distributor')
            ->where('providerable_id',$this->user->id)->where('confirm',1);

        if ($request->from_date && $request->to_date){
            $merchant = $merchant
                ->whereBetween(\DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]);
        }
        if ($request->from_date  && $request->to_date == null){
            $merchant = $merchant->whereDate('created_at',$request->from_date);
        }


        $merchant =  $merchant->take(10)->get();

       $data = MerchantTransactionsResource::collection($merchant);

        return ApiController::respondWithSuccess($data);

    }
    public function transfer_to_merchant(TransferToMerchantRequest $request)
    {
        DB::beginTransaction();

        try {
            // Lock distributor (provider) and merchant to avoid race conditions
            $distributor = Distributor::where('id', $this->user->id)->lockForUpdate()->first();
            $merchant = Merchant::where('id', $request->merchant_id)->lockForUpdate()->first();

            if ($distributor->balance < $request->amount) {
                return ApiController::respondWithError(trans('api.Your_balance_is_not_enough'));
            }

            // Create the transfer explicitly (avoid using $request->all())
            $transfer = Transfer::create([
                'amount' => $request->amount,
                'providerable_id' => $distributor->id,
                'providerable_type' => Distributor::class,
                'userable_id' => $merchant->id,
                'userable_type' => Merchant::class,
                'type' => 'transfer',
                'transfer_type' => 'delay',
                'transfers_total' => $merchant->transfer_total + $request->amount,
                'balance_total' => $merchant->balance + $request->amount,
                'indebtedness' => $merchant->indebtedness + $request->amount,
            ]);

            // Update merchant
            $merchant->update([
                'balance' => $merchant->balance + $request->amount,
                'transfer_total' => $merchant->transfer_total + $request->amount,
                'indebtedness' => $merchant->indebtedness + $request->amount,
            ]);

            // Update distributor (this->user)
            $distributor->update([
                'balance' => $distributor->balance - $request->amount,
                'transfer_total' => $distributor->transfer_total + $request->amount,
                'transfers_total_check' => $distributor->transfers_total_check + $request->amount,
            ]);

            // Check profits logic
            if ($distributor->transfers_total_check >= $distributor->distributions) {
                $distributor->update([
                    'profits' => $distributor->profits + $distributor->offer_amount,
                    'transfers_total_check' => $distributor->transfers_total_check != 0
                        ? $distributor->transfers_total_check - $distributor->distributions
                        : 0,
                ]);
            }

            // Update external transfer fields if needed
            updateTransfer($transfer, $merchant);

            // Handle DistributorIndebtedness
            $check = DistributorIndebtedness::where('distributor_id', $distributor->id)
                ->where('merchant_id', $merchant->id)
                ->lockForUpdate()
                ->first();

            if ($check) {
                $check->update([
                    'total' => $check->total + $request->amount,
                ]);
            } else {
                DistributorIndebtedness::create([
                    'distributor_id' => $distributor->id,
                    'merchant_id' => $merchant->id,
                    'total' => $request->amount,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'status' => http_response_code(),
                'data' => ['id' => $transfer->id],
                'message' => null,
            ])->setStatusCode(200);

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiController::respondWithError($e->getMessage());
        }
    }



    public  function generate_pdf_transfers_to_merchant($id) {

        $transfer = Transfer::whereId($id)
            ->where('providerable_id',$this->user->id)
        ->where('providerable_type','App\Models\Distributor')->first();
        if (!$transfer){
            return ApiController::respondWithServerError();
        }
        $to_user = $transfer->distributor->name;
        $to_user_phone = $transfer->distributor->phone;
        $to_user_tax_number = $transfer->distributor->tax_number;



        $all_data=[
            'transfer'=>$transfer,
            'to_user'=>$to_user,
            'to_user_phone'=>$to_user_phone,
            'to_user_tax_number'=>isset($to_user_tax_number) ? $to_user_tax_number : null,
            'to_user_commercial_number'=>isset($to_user_commercial_number) ? $to_user_commercial_number : null,
            'qrcode'=>$transfer->generateQRCode()
        ];

        $html = view('pdf.distributor_pdf_balance')->with($all_data)->render();
        $id = $transfer->id;
        $pdfarr = [
            'title'=>'الفاتورة ',
            'data'=>$html, // render file blade with content html
            'header'=>['show'=>false], // header content
            'footer'=>['show'=>false], // Footer content
            'font'=>'aealarabiya', //  dejavusans, aefurat ,aealarabiya ,times
            'font-size'=>12, // font-size
            'text'=>'', //Write
            'rtl'=>true, //true or false
            'creator'=>'Korot', // creator file - you can remove this key
            'keywords'=>$id , // keywords file - you can remove this key
            'subject'=>'Invoice', // subject file - you can remove this key
            'filename'=>'Invoice-'.$id.'.pdf', // filename example - invoice.pdf
            'display'=>'stream', // stream , download , print
        ];

        return PDF::HTML($pdfarr);

    }
    public  function generate_pdf_collect_from_merchant($id) {

        $transfer = Transfer::whereId($id)
            ->where('providerable_id',$this->user->id)
        ->where('providerable_type','App\Models\Distributor')->first();
        if (!$transfer){
            return ApiController::respondWithServerError();
        }
        $to_user = $transfer->distributor->name;
        $to_user_phone = $transfer->distributor->phone;
        $to_user_tax_number = $transfer->distributor->tax_number;



        $all_data=[
            'transfer'=>$transfer,
            'to_user'=>$to_user,
            'to_user_phone'=>$to_user_phone,
            'to_user_tax_number'=>isset($to_user_tax_number) ? $to_user_tax_number : null,
            'to_user_commercial_number'=>isset($to_user_commercial_number) ? $to_user_commercial_number : null,
            'qrcode'=>$transfer->generateQRCode()
        ];

        $html = view('pdf.distributor_collection_pdf_balance')->with($all_data)->render();
        $id = $transfer->id;
        $pdfarr = [
            'title'=>'الفاتورة ',
            'data'=>$html, // render file blade with content html
            'header'=>['show'=>false], // header content
            'footer'=>['show'=>false], // Footer content
            'font'=>'aealarabiya', //  dejavusans, aefurat ,aealarabiya ,times
            'font-size'=>12, // font-size
            'text'=>'', //Write
            'rtl'=>true, //true or false
            'creator'=>'Korot', // creator file - you can remove this key
            'keywords'=>$id , // keywords file - you can remove this key
            'subject'=>'Invoice', // subject file - you can remove this key
            'filename'=>'Invoice-'.$id.'.pdf', // filename example - invoice.pdf
            'display'=>'stream', // stream , download , print
        ];

        return PDF::HTML($pdfarr);

    }
    public function collect_from_merchant(TransferToMerchantRequest $request){
        $merchant = Merchant::find($request->merchant_id);
        $check =DistributorIndebtedness::where('distributor_id',$this->user->id)
            ->where('merchant_id',$merchant->id)->first();
        if (! $check){
            return ApiController::respondWithError(trans('api.no_indebtedness'));
        }else if ($check->total < $request->amount){
            return ApiController::respondWithError(trans('api.larger_indebtedness'));
        }


        $request['providerable_id']=$this->user->id;
        $request['providerable_type'] = "App\Models\Distributor";
        $request['userable_id']=$request->merchant_id;
        $request['userable_type']="App\Models\Merchant";
        $request['type']="collection";
        $request['collection_total']=$merchant->collection_total + $request->amount;
        $request['balance_total']=$merchant->balance;
        $request['indebtedness']= $merchant->indebtedness != 0 ? $merchant->indebtedness - $request->amount : 0;

        $transfer = Transfer::create($request->all());
        $transfer->update([
            'collection_id'=>"S".$transfer->id
        ]);
//        add_journals($transfer->id,"collection");
        $merchant->update([
            'collection_total'=>$merchant->collection_total + $request->amount,
            'indebtedness'=>$merchant->indebtedness != 0 ? $merchant->indebtedness - $request->amount : 0,
        ]);
        $this->user->update([
            'collection_total'=> $this->user->collection_total + $request->amount,
        ]);
        updateTransfer($transfer,$merchant);

        if ($check){
            $check->update([
                'total'=>$check->total != 0  ? $check->total - $request->amount : 0
            ]);
        }
        $data =[
            'id'=>$transfer->id
        ];
        return response()->json(['success'=> true,'status' =>  http_response_code() , 'data'=>$data , 'message'=>null])->setStatusCode(200);;


    }
}
