<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Merchant\BuyCreditOnlineRequest;
use App\Http\Requests\Api\Merchant\ChargeCreditOnlineRequest;
use App\Http\Requests\Api\Merchant\ConfirmCreditOnlineRequest;
use App\Http\Requests\Api\Merchant\TransferCreditToBankRequest;
use App\Http\Resources\Api\Merchant\BankInfoResource;
use App\Http\Resources\Api\Merchant\CreditTransactionsResource;
use App\Models\GeadiaWallet;
use App\Models\Setting;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Transfers\Entities\Transfer;

class CreditController extends Controller
{
    //
    public $user;
    public function __construct()
    {
        $this->user = auth()->guard('api_merchant')->user();
    }
    public function bank_info(){
        $settings = Setting::find(1);
        $data = new BankInfoResource($settings);
        return ApiController::respondWithSuccess($data);
    }
    public function credit_transaction(Request $request){
        $transaction =$this->user->userable()->where('type','recharge')->Order();
        if ($request->type == "week"){
            $transaction = $transaction->whereBetween('created_at',
                [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
            );
        }
        if ($request->type == "month"){
            $transaction = $transaction->whereMonth(
                'created_at', '=', Carbon::now()->month
            );

        }
        if ($request->type == "year"){
            $transaction = $transaction->whereYear('created_at', '=', Carbon::now()->year);
        }
        if ($request->type == "exact_time"){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);
            $transaction = $transaction->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }


        $data=  $transaction->paginate(20);
        CreditTransactionsResource::collection($data);
        return ApiController::respondWithSuccess($data);
    }
    public function buy_credit_bank_transfer(TransferCreditToBankRequest $request){
        $request['type']="recharge";
        $request['userable_id'] = $this->user->id;
        $request['userable_type']=get_class($this->user);
        $request['pay_type']="bank_transfer";
        $request['confirm'] = 0;
        $request['image'] =  UploadImage($request->file('photo'), 'transfers', '/uploads/transfers');

        $transfer = Transfer::create($request->all());
        updateTransfer($transfer,$this->user);

//        sendMobileNotification($this->user->id,get_class($this->user),title_notifications('recharge_transfer'),messages_notifications('profits',$request->amount),6,null);
//        saveNotification('6', serialize(title_notifications('recharge_transfer')) , serialize(messages_notifications('profits',$request->amount)),$this->user->id,get_class($this->user));

        return response()->json(['success'=> true,'status' =>  http_response_code() , 'data'=>null , 'message'=>null])->setStatusCode(200);

    }
    public function charge_credit_online(ChargeCreditOnlineRequest $request){
        $request['type']="recharge";
        $request['userable_id'] = $this->user->id;
        $request['userable_type']=get_class($this->user);
        $request['pay_type']="online";
//        $request['confirm'] = 0;
        $request['paid_order'] = "not_paid";
        $percentage = $this->user->geidea_percentage ? $this->user->geidea_percentage : settings()->geidea_percentage;
        $get_commission = $request->amount * $percentage;

        $result = ($request->amount) - $get_commission;


        $request['geidea_commission']=$get_commission;
        $request['geidea_percentage']=$percentage;
        $transfer = Transfer::create($request->all());
        $request['balance_total']=$this->user->balance + $result;





        $data =new CreditTransactionsResource($transfer);

        return response()->json(['success'=> true,'status' =>  http_response_code() , 'data'=>$data , 'message'=> null])->setStatusCode(200);

    }
    public function confirm_credit_online(ConfirmCreditOnlineRequest $request){
        $transfer = Transfer::find($request->transfer_id);
        if ($transfer->pay_type != "online" || $transfer->paid_order == "paid"){
            return ApiController::respondWithError(trans('api.not_available'));
        }
        $transfer->update([
            'confirm'=>1,
            'paid_order'=>"paid",
            'transaction_id'=>$request->transaction_id,

        ]);

        $statistics = \App\Models\Statistic::find(1);
        $statistics->update([
            'geidea_commission' => $statistics->geidea_commission + $transfer->geidea_commission
        ]);

        $wallet = Wallet::create([
            'transfer_id'=>$transfer->id,
            'merchant_id'=>$this->user->id,
            'balance'=>$transfer->amount,
            'previous_balance'=>$this->user->balance,
            'current_balance'=>$this->user->balance + $transfer->amount,
            'date'=>Carbon::now(),
        ]);
        $old_balance =$this->user->balance;
        $this->user->update([
            'balance'=>$this->user->balance + $transfer->amount,
        ]);

        /*محفظة جيديا */
        add_geadia($this->user,$transfer->amount,"charge",$transfer,$request->transaction_id);

        updateTransfer($transfer,$this->user);

        $data =[
            'merchant_name'=>$this->user->name,
            'balance'=>$wallet->balance,
            'previous_balance'=>$wallet->previous_balance,
            'current_balance'=>$wallet->current_balance,
            'date'=>Carbon::parse($wallet->date)->format('Y-m-d H:i:s'),

        ];
        sendMobileNotification($this->user->id,get_class($this->user),title_notifications('recharge_online'),messages_notifications('recharge_online',$request->amount),6,null);
        saveNotification('6', serialize(title_notifications('recharge_online')) , serialize(messages_notifications('recharge_online',$request->amount)),$this->user->id,get_class($this->user));

        return response()->json(['success'=> true,'status' =>  http_response_code() , 'data'=>$data , 'message'=>trans('api.charge_balance_successfuly',['balance'=>number_format($request->amount,2),'geadia'=> $transfer->geidea_percentage ,'old'=> number_format($old_balance,2), 'new'=>number_format($this->user->balance,2) ])])->setStatusCode(200);

    }
    public function buy_credit_online(BuyCreditOnlineRequest $request){
        $request['type']="recharge";
        $request['userable_id'] = $this->user->id;
        $request['userable_type']=get_class($this->user);
        $request['pay_type']="online";
        $request['confirm'] = 1;
        $percentage = $this->user->geidea_percentage ? $this->user->geidea_percentage : settings()->geidea_percentage;
        $get_commission = $request->amount * $percentage;
        $statistics = \App\Models\Statistic::find(1);
        $statistics->update([
            'geidea_commission' => $statistics->geidea_commission + $get_commission
        ]);
        $result = ($request->amount) - $get_commission;


        $request['geidea_commission']=$get_commission;
        $request['geidea_percentage']=$percentage;
        $transfer = Transfer::create($request->all());
        $request['balance_total']=$this->user->balance + $result;
        $wallet = Wallet::create([
            'transfer_id'=>$transfer->id,
            'merchant_id'=>$this->user->id,
            'balance'=>$result,
            'previous_balance'=>$this->user->balance,
            'current_balance'=>$this->user->balance + $result,
            'date'=>Carbon::now(),
        ]);
        $old_balance =$this->user->balance;
        $this->user->update([
            'balance'=>$this->user->balance + $result,
        ]);

        /*محفظة جيديا */
        add_geadia($this->user,$request->amount,"charge",$transfer,$request->transaction_id);

        updateTransfer($transfer,$this->user);

        $data =[
            'merchant_name'=>$this->user->name,
            'balance'=>$wallet->balance,
            'previous_balance'=>$wallet->previous_balance,
            'current_balance'=>$wallet->current_balance,
            'date'=>Carbon::parse($wallet->date)->format('Y-m-d H:i:s'),

        ];
        sendMobileNotification($this->user->id,get_class($this->user),title_notifications('recharge_online'),messages_notifications('recharge_online',$request->amount),6,null);
        saveNotification('6', serialize(title_notifications('recharge_online')) , serialize(messages_notifications('recharge_online',$request->amount)),$this->user->id,get_class($this->user));

        return response()->json(['success'=> true,'status' =>  http_response_code() , 'data'=>$data , 'message'=>trans('api.charge_balance_successfuly',['balance'=>number_format($request->amount,2),'geadia'=> $percentage ,'old'=> number_format($old_balance,2), 'new'=>number_format($this->user->balance,2) ])])->setStatusCode(200);

    }
}
