<?php

namespace App\Http\Controllers\Api\Distributor;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Distributor\TransferIndebtenessToBankRequest;
use App\Http\Requests\Api\Distributor\TransferIndebtnessOnlineRequest;
use Illuminate\Http\Request;
use Modules\Transfers\Entities\Transfer;

class IndebtednessController extends Controller
{
    //
    public $user;
    public function __construct()
    {
        $this->user = auth()->guard('api_distributor')->user();
    }
    public function indebtedness_transfer_bank(TransferIndebtenessToBankRequest $request){
        $indebtedness = $this->user->indebtedness * 5/100;
          if ($request->amount < $indebtedness ){
              return ApiController::respondWithError(trans('api.not_available'));
          }
        $request['type']="payment";
        $request['userable_id'] = $this->user->id;
        $request['userable_type']=get_class($this->user);
        $request['pay_type']="bank_transfer";
        $request['confirm'] = 0;
        $request['indebtedness'] = $this->user->indebtedness - $request->amount;
        $request['image'] =  UploadImage($request->file('photo'), 'transfers', '/uploads/transfers');

        $transfer = Transfer::create($request->all());
        updateTransfer($transfer,$this->user);
        return response()->json(['success'=> true,'status' =>  http_response_code() , 'data'=>null , 'message'=>null])->setStatusCode(200);


    }
    public function indebtedness_online(TransferIndebtnessOnlineRequest $request){
        $indebtedness = $this->user->indebtedness * 5/100;
//          if ($request->amount < $indebtedness ){
//              return ApiController::respondWithError(trans('api.not_available'));
//          }
        $request['type']="payment";
        $request['userable_id'] = $this->user->id;
        $request['userable_type']=get_class($this->user);
        $request['pay_type']="online";
        $request['confirm'] = 1;
        $request['indebtedness'] = $this->user->indebtedness - $request->amount;
        $transfer = Transfer::create($request->all());
        $this->user->update([
            'indebtedness'=>$this->user->indebtedness - $request->amount,
        ]);
        updateTransfer($transfer,$this->user);
        return response()->json(['success'=> true,'status' =>  http_response_code() , 'data'=>null , 'message'=>null])->setStatusCode(200);


    }
}
