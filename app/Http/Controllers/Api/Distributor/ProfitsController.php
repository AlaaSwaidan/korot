<?php

namespace App\Http\Controllers\Api\Distributor;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Merchant\AddProfitToBalanceRequest;
use App\Http\Requests\Api\Merchant\TransferProfitToBankRequest;
use Illuminate\Http\Request;
use Modules\Transfers\Entities\BankTransfer;
use Modules\Transfers\Entities\Transfer;

class ProfitsController extends Controller
{
    //
    public $user;
    public function __construct()
    {
        $this->user = auth()->guard('api_distributor')->user();
    }
    public function transfer_profit_to_bank(TransferProfitToBankRequest $request){
        if ($this->user->profits < $request->amount){
            return ApiController::respondWithError(trans('api.not_available'));
        }
        $request['type']="profits";
        $request['userable_id'] = $this->user->id;
        $request['userable_type']=get_class($this->user);
        $request['profits_total']=$this->user->profits - $request->amount;
        $request['pay_type']="bank_transfer";
        $request['confirm'] = 0;
        $transfer = Transfer::create($request->all());
        updateTransfer($transfer,$this->user);
        $request['transfer_id']=$transfer->id;
        BankTransfer::create($request->all());
//        $this->user->update([
//            'profits'=>$this->user->profits - $request->amount,
//        ]);
        return response()->json(['success'=> true,'status' =>  http_response_code() , 'data'=>null , 'message'=>null])->setStatusCode(200);;

    }
    public function add_profits_to_balance(AddProfitToBalanceRequest $request){
        if ($this->user->profits < $request->amount){
            return ApiController::respondWithError(trans('api.not_available'));
        }
        $request['type']="profits";
        $request['userable_id'] = $this->user->id;
        $request['userable_type']=get_class($this->user);
        $request['profits_total']=$this->user->profits - $request->amount;
        $request['balance_total']=$this->user->balance + $request->amount;
        $request['pay_type']="balance";
        $transfer = Transfer::create($request->all());
        updateTransfer($transfer,$this->user);
        $request['transfer_id']=$transfer->id;
        BankTransfer::create($request->all());
        $this->user->update([
            'profits'=>$this->user->profits - $request->amount,
            'balance'=>$this->user->balance + $request->amount,
        ]);
        sendMobileNotification($this->user->id,get_class($this->user),title_notifications('profits'),messages_notifications('profits',$request->amount),4,null);
        saveNotification('4', serialize(title_notifications('profits')) , serialize(messages_notifications('profits',$request->amount)),$this->user->id,get_class($this->user));

        return response()->json(['success'=> true,'status' =>  http_response_code() , 'data'=>null , 'message'=>null])->setStatusCode(200);;

    }
}
