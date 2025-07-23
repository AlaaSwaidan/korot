<?php

namespace Modules\Indebtedness\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Transfers\Entities\Transfer;
use PDF;

class IndebtednessMerchantRepository
{



    public function store_indebtedness($request,$merchant)
    {
        try {

            $request['providerable_id']=auth()->guard('admin')->user()->id;
            $request['providerable_type'] = "App\Models\Admin";
            $request['userable_id']=$merchant->id;
            $request['userable_type']=get_class($merchant);
            $request['type']="indebtedness";
            $request['balance_total']=$merchant->balance;
            $request['indebtedness']= $merchant->indebtedness  + $request->amount;

            $transfer = Transfer::create($request->all());
            $merchant->update([
                'indebtedness'=>$merchant->indebtedness + $request->amount,
            ]);
            updateTransfer($transfer,$merchant);
            return $transfer;
        } catch (\Exception $exception) {
            return redirect()->route('admin.indebtedness.index','type=merchants')->with('warning', 'Error , contact system');
        }
    }
    public function store_repayment($request,$merchant)
    {
        try {

            $request['providerable_id']=auth()->guard('admin')->user()->id;
            $request['providerable_type'] = "App\Models\Admin";
            $request['userable_id']=$merchant->id;
            $request['userable_type']=get_class($merchant);
            $request['type']="repayment";
            $request['balance_total']=$merchant->balance + $request->amount;
            $request['repayment_total']=$merchant->repayment_total + $request->amount;


            $transfer = Transfer::create($request->all());

            $merchant->update([
                'repayment_total'=>$merchant->repayment_total + $request->amount,
                'balance'=>$merchant->balance + $request->amount,
            ]);
            auth()->guard('admin')->user()->update([
                'repayment_total'=>auth()->guard('admin')->user()->repayment_total + $request->amount,
                'balance'=>auth()->guard('admin')->user()->balance - $request->amount,
            ]);
            sendMobileNotification($merchant->id,$transfer->userable_type,title_notifications('repayment'),messages_notifications('repayment',$transfer->amount),5,null);
            saveNotification('5', serialize(title_notifications('repayment')) , serialize(messages_notifications('repayment',$transfer->amount)),$merchant->id,$transfer->userable_type);

            return $transfer;
        } catch (\Exception $exception) {
            return redirect()->route('admin.indebtedness.index','type=merchants')->with('warning', 'Error , contact system');
        }
    }

}
