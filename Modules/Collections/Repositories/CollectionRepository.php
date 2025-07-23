<?php

namespace Modules\Collections\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Transfers\Entities\Transfer;
use PDF;

class CollectionRepository
{

    public function index($user)
    {

        $data =$user->userable()->where('type','collection')->Order()->paginate(20)->appends(request()->except('page'));
        return $data;
    }

    public function store_collection($request,$merchant)
    {
        try {

            $request['providerable_id']=auth()->guard('admin')->user()->id;
            $request['providerable_type'] = "App\Models\Admin";
            $request['userable_id']=$merchant->id;
            $request['userable_type']=get_class($merchant);
            $request['type']="collection";
            $request['collection_total']=$merchant->collection_total + $request->amount;
            $request['balance_total']=$merchant->balance;
            $request['indebtedness']= $merchant->indebtedness != 0 ? $merchant->indebtedness - $request->amount : 0;

            $transfer = Transfer::create($request->all());
            $transfer->update([
                'collection_id'=>"S".$transfer->id
            ]);
            add_journals($transfer->id,"collection");
            $merchant->update([
                'collection_total'=>$merchant->collection_total + $request->amount,
                'indebtedness'=>$merchant->indebtedness != 0 ? $merchant->indebtedness - $request->amount : 0,
            ]);
            auth()->guard('admin')->user()->update([
                'collection_total'=>auth()->guard('admin')->user()->collection_total + $request->amount,
            ]);
            updateTransfer($transfer,$merchant);
            return $transfer;
        } catch (\Exception $exception) {
            return redirect()->route('admin.collections.index','type=merchants')->with('warning', 'Error , contact system');
        }
    }


    public  function generate_pdf($transfer,$type) {
        if ($type == "admins"){
            $to_user = $transfer->admin->name;
            $to_user_phone = $transfer->admin->phone;
        }elseif ($type == "merchant"){
            $to_user = $transfer->merchant->name;
            $to_user_phone = $transfer->merchant->phone;
            $to_user_tax_number = $transfer->merchant->tax_number;
            $to_user_commercial_number = $transfer->merchant->commercial_number;
        }elseif ($type == "distributors"){
            $to_user = $transfer->distributor->name;
            $to_user_phone = $transfer->distributor->phone;
            $to_user_tax_number = $transfer->distributor->tax_number;
        }

        $all_data=[
            'transfer'=>$transfer,
            'to_user'=>$to_user,
            'to_user_phone'=>$to_user_phone,
            'to_user_tax_number'=>isset($to_user_tax_number) ? $to_user_tax_number : null,
            'to_user_commercial_number'=>isset($to_user_commercial_number) ? $to_user_commercial_number : null,
            'qrcode'=>$transfer->generateQRCode()
        ];

        $html = view('collections::pdf.pdf_balance')->with($all_data)->render();
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
    public function search($request,$user)
    {

        $data = $user->userable()->where('type','collection')->Order();
        if ($request->time == "today"){
            $data = $data->whereDate('created_at',Carbon::now());
        }
        if ($request->time == "yesterday"){
            $data = $data->whereDate('created_at',Carbon::now()->subDay());
        }
        if ($request->time == "current_week"){
            $data = $data->whereBetween('created_at',
                [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
            );
        }
        if ($request->time == "current_month"){
            $data = $data->whereBetween('created_at',
                [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            );
        }
        if ($request->time == "month_ago"){
            $data = $data->whereMonth(
                'created_at', '=', Carbon::now()->subMonth()->month
            );
        }
        if ($request->time == "exact_time"){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);
            $data = $data->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }
        $data =$data->paginate(20)->appends(request()->except('page'));
        $data->appends(['time' => $request->time,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);

        return $data;
    }

}
