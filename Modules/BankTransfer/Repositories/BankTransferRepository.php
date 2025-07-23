<?php

namespace Modules\BankTransfer\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Transfers\Entities\Transfer;
use PDF;

class BankTransferRepository
{

    public function index($type)
    {
        $data =Transfer::where('type',$type)->where('pay_type','bank_transfer')->where('confirm',0)->Order()->paginate(20)->appends(request()->except('page'));
        return $data;
    }
    public function accept($request)
    {
//        try {
            $data = Transfer::find($request->id);
            $user = getUserModel($data->userable_type,$data->userable_id);
            if ($data->type == "profits"){
                $request['balance_total']=$user->balance + $data->amount;
                $user->update([
                    'profits'=>$user->profits - $data->amount,
                    'balance'=>$user->balance + $data->amount,
                ]);
                sendMobileNotification($user->id,$data->userable_type,title_notifications('profits'),messages_notifications('profits',$data->amount),4,null);
                saveNotification('4', serialize(title_notifications('profits')) , serialize(messages_notifications('profits',$data->amount)),$user->id,$data->userable_type);

            }elseif ($data->type == "recharge"){
                $request['balance_total']=$user->balance + $data->amount;
                $user->update([
                    'balance'=>$user->balance + $data->amount,
                ]);
                sendMobileNotification($user->id,$data->userable_type,title_notifications('recharge_transfer'),messages_notifications('recharge_transfer',$data->amount),3,null);
                saveNotification('3', serialize(title_notifications('recharge_transfer')) , serialize(messages_notifications('recharge_transfer',$data->amount)),$user->id,$data->userable_type);

            }elseif ($data->type == "payment"){
                $request['indebtedness'] = $user->indebtedness - $data->amount;
                $user->update([
                    'indebtedness'=>$user->indebtedness - $data->amount,
                ]);
                sendMobileNotification($user->id,$data->userable_type,title_notifications('payment_transfer'),messages_notifications('payment_transfer',$data->amount),3,null);
                saveNotification('3', serialize(title_notifications('payment_transfer')) , serialize(messages_notifications('payment_transfer',$data->amount)),$user->id,$data->userable_type);

            }
            $request['confirm']=1;
            $updated = $data->update($request->all());
            return $updated;
//        } catch (\Exception $exception) {
//            return redirect()->route('admin.transactions.index','type='.$data->type)->with('warning', 'Error , contact system');
//
//        }
    }
    public function refuse($request)
    {
        try {
            $data = Transfer::find($request->id);
            $updated = $data->update([
                'confirm'=>2 // refuse
            ]);
            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.transactions.index','type='.$data->type)->with('warning', 'Error , contact system');

        }
    }


}
