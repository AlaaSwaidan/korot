<?php

namespace Modules\Indebtedness\Repositories;

use Modules\Transfers\Entities\Transfer;

class IndebtednessAdminRepository
{


    public function store_indebtedness($request,$admin)
    {
        try {


            $request['providerable_id']=auth()->guard('admin')->user()->id;
            $request['providerable_type'] = "App\Models\Admin";
            $request['userable_id']=$admin->id;
            $request['userable_type']=get_class($admin);
            $request['type']="indebtedness";
            $request['balance_total']=$admin->balance;
            $request['indebtedness']= $admin->indebtedness  + $request->amount;

            $transfer = Transfer::create($request->all());

            $admin->update([
                'indebtedness'=>$admin->indebtedness + $request->amount,
            ]);

            updateTransfer($transfer,$admin);
            return $transfer;
        } catch (\Exception $exception) {
            return redirect()->route('admin.collections.index','type=admins')->with('warning', 'Error , contact system');
        }
    }

    public function store_repayment($request,$admin)
    {
        try {


            $request['providerable_id']=auth()->guard('admin')->user()->id;
            $request['providerable_type'] = "App\Models\Admin";
            $request['userable_id']=$admin->id;
            $request['userable_type']=get_class($admin);
            $request['type']="repayment";
            $request['balance_total']=$admin->balance + $request->amount;
            $request['repayment_total']=$admin->repayment_total + $request->amount;


            $transfer = Transfer::create($request->all());

            $admin->update([
                'repayment_total'=>$admin->repayment_total + $request->amount,
                'balance'=>$admin->balance + $request->amount,
            ]);
            auth()->guard('admin')->user()->update([
                'repayment_total'=>auth()->guard('admin')->user()->repayment_total + $request->amount,
                'balance'=>auth()->guard('admin')->user()->balance - $request->amount,
            ]);
            sendMobileNotification($admin->id,$transfer->userable_type,title_notifications('repayment'),messages_notifications('repayment',$transfer->amount),5,null);
            saveNotification('5', serialize(title_notifications('repayment')) , serialize(messages_notifications('repayment',$transfer->amount)),$admin->id,$transfer->userable_type);

            return $transfer;
        } catch (\Exception $exception) {
            return redirect()->route('admin.collections.index','type=admins')->with('warning', 'Error , contact system');
        }
    }




}
