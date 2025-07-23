<?php

namespace Modules\Processes\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Transfers\Entities\Transfer;
use PDF;

class ProcessesRepository
{

    public function index($type)
    {

        $data =Transfer::where('userable_type',getClassModel($type))->Order()->paginate(20)->appends(request()->except('page'));
        return $data;
    }


    public  function generate_pdf($transfer,$type) {
        if ($type == "admins"){
            $to_user = $transfer->admin->name;
            $to_user_phone = $transfer->admin->phone;
        }elseif ($type == "merchant"){
            $to_user = $transfer->merchant->name;
            $to_user_phone = $transfer->merchant->phone;
        }elseif ($type == "distributors"){
            $to_user = $transfer->distributor->name;
            $to_user_phone = $transfer->distributor->phone;
        }

        $all_data=[
            'transfer'=>$transfer,
            'to_user'=>$to_user,
            'to_user_phone'=>$to_user_phone,
            'qrcode'=>$transfer->generateQRCode()
        ];

        $html = view('indebtedness::pdf.pdf_balance')->with($all_data)->render();
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
    public function search($request)
    {

        $data = Transfer::where('userable_type',getClassModel($request->type))->Order();
        if ($request->time == "today"){
            $data = $data->whereDate('created_at',Carbon::now());
        }
        if ($request->time == "yesterday"){
            $data = $data->whereDate('created_at',Carbon::now()->subDay());
        }
        if ($request->process_type ){
            $data = $data->where('type',$request->process_type);
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
        if ($request->user_name){
            $data = $data->whereHas('user',function ($q) use($request){
                $q->where('name', 'LIKE', "%$request->user_name%");
            });
        }
        $data =$data->paginate(20)->appends(request()->except('page'));
        $data->appends(['time' => $request->time,'from_date'=>$request->from_date,
            'to_date'=>$request->to_date,'user_name'=>$request->user_name]);

        return $data;
    }

}
