<?php

namespace Modules\Accounts\Repositories;

use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Transfers\Entities\Transfer;
use PDF;

class JournalsRepository
{

    public function search($request)
    {

        $data = Journal::Order();
        $new_data = clone $data;
        if ($request->from_date && $request->to_date){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);
            $today =' التاريخ '.$startDate->format('Y-m-d').' الى '.$endDate->format('Y-m-d');
            $data = $data->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }

        $data =$data->paginate(20)->appends(request()->except('page'));
        $data->appends(['from_date'=>$request->from_date,
            'to_date'=>$request->to_date]);

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

}
