<?php

namespace Modules\Indebtedness\Repositories;

use Modules\Transfers\Entities\Transfer;
use PDF;

class IndebtednessDistributorRepository
{


    public function store_indebtedness($request,$distributor)
    {
        try {


            $request['providerable_id']=auth()->guard('admin')->user()->id;
            $request['providerable_type'] = "App\Models\Admin";
            $request['userable_id']=$distributor->id;
            $request['userable_type']=get_class($distributor);
            $request['type']="indebtedness";
            $request['balance_total']=$distributor->balance;
            $request['indebtedness']= $distributor->indebtedness  + $request->amount;

            $transfer = Transfer::create($request->all());

            $distributor->update([
                'indebtedness'=>$distributor->indebtedness + $request->amount,
            ]);

            updateTransfer($transfer,$distributor);
            return $transfer;
        } catch (\Exception $exception) {
            return redirect()->route('admin.indebtedness.index','type=distributors')->with('warning', 'Error , contact system');
        }
    }
    public function store_repayment($request,$distributor)
    {
        try {

            $request['providerable_id']=auth()->guard('admin')->user()->id;
            $request['providerable_type'] = "App\Models\Admin";
            $request['userable_id']=$distributor->id;
            $request['userable_type']=get_class($distributor);
            $request['type']="repayment";
            $request['balance_total']=$distributor->balance + $request->amount;
            $request['repayment_total']=$distributor->repayment_total + $request->amount;


            $transfer = Transfer::create($request->all());

            $distributor->update([
                'repayment_total'=>$distributor->repayment_total + $request->amount,
                'balance'=>$distributor->balance + $request->amount,
            ]);
            auth()->guard('admin')->user()->update([
                'repayment_total'=>auth()->guard('admin')->user()->repayment_total + $request->amount,
                'balance'=>auth()->guard('admin')->user()->balance - $request->amount,
            ]);
            sendMobileNotification($distributor->id,$transfer->userable_type,title_notifications('repayment'),messages_notifications('repayment',$transfer->amount),5,null);
            saveNotification('5', serialize(title_notifications('repayment')) , serialize(messages_notifications('repayment',$transfer->amount)),$distributor->id,$transfer->userable_type);

            return $transfer;
        } catch (\Exception $exception) {
            return redirect()->route('admin.indebtedness.index','type=distributors')->with('warning', 'Error , contact system');
        }
    }

}
