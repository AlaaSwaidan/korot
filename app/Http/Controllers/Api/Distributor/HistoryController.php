<?php

namespace App\Http\Controllers\Api\Distributor;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Distributor\AllTransactionsResource;
use App\Http\Resources\Api\Distributor\MerchantTransactionsResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Transfers\Entities\Transfer;
use PDF;

class HistoryController extends Controller
{
    //
    public $user;
    public function __construct()
    {
        $this->user = auth()->guard('api_distributor')->user();
    }
    public function history(Request $request){
        $transaction =Transfer::where('confirm',1)->Order()->where('providerable_type','App\Models\Distributor')
            ->where('providerable_id',$this->user->id)->where('confirm',1);
        if ($request->type == "week"){
            $transaction = $transaction->whereBetween('created_at',
                [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
            );
        }
        if ($request->type == "yesterday"){
            $transaction = $transaction->whereDate(
                'created_at', '=', Carbon::now()->subDay()->format('Y-m-d')
            );

        }
        if ($request->type == "today"){
            $transaction = $transaction->whereDate(
                'created_at', '=', Carbon::now()->format('Y-m-d')
            );

        }
        if ($request->type == "exact_time"){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);
            $transaction = $transaction->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }
        $transaction= $transaction->paginate(10);
        MerchantTransactionsResource::collection($transaction);
        return ApiController::respondWithSuccess($transaction);
    }
    public  function generate_pdf_collection($id) {
        $decrypt= base64_decode($id);
        $transfer = Transfer::find($decrypt);
        $to_user = $transfer->merchant->name;
        $to_user_phone = $transfer->merchant->phone;
        $to_user_tax_number = $transfer->merchant->tax_number;
        $to_user_commercial_number = $transfer->merchant->commercial_number;


        $all_data=[
            'transfer'=>$transfer,
            'to_user'=>$to_user,
            'to_user_phone'=>$to_user_phone,
            'to_user_tax_number'=>isset($to_user_tax_number) ? $to_user_tax_number : null,
            'to_user_commercial_number'=>isset($to_user_commercial_number) ? $to_user_commercial_number : null,
            'qrcode'=>$transfer->generateQRCode()
        ];

        $html = view('pdf.pdf_balance_collection')->with($all_data)->render();

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
    public  function generate_pdf_transfer($id) {

        $decrypt= base64_decode($id);
        $transfer = Transfer::find($decrypt);
        $to_user = $transfer->merchant->name;
        $to_user_phone = $transfer->merchant->phone;
        $to_user_tax_number = $transfer->merchant->tax_number;
        $to_user_commercial_number = $transfer->merchant->commercial_number;


        $all_data=[
            'transfer'=>$transfer,
            'to_user'=>$to_user,
            'to_user_phone'=>$to_user_phone,
            'to_user_tax_number'=>isset($to_user_tax_number) ? $to_user_tax_number : null,
            'to_user_commercial_number'=>isset($to_user_commercial_number) ? $to_user_commercial_number : null,
            'qrcode'=>$transfer->generateQRCode()
        ];

        $html = view('pdf.pdf_balance_transfer')->with($all_data)->render();



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
}
