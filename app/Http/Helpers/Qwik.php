<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Api\Merchant\CardResource;
use App\Models\Card;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

function create_qwik_order($product_id, $count, $package, $user,$payment_method,$transaction_id = null){
    /*
    Test
    $api_username = 'ksuptest';
    $api_pasword = '87654321';
    */

    $api_username = 'ON70465182';
    $api_password = 'ef334EDbcyTb';
    $api_terminal_id = '70465182';

    $today = Carbon::today();
    $amount = '1050';


    $cards = [];
    if ($new_price =$user->prices()->where('package_id',$package->id)->where('type',$user->type)->first()){
        $merchant_price = $new_price->price;
    }
    $new_price = isset($merchant_price) ? $merchant_price :  $package->prices()->where('type',$user->type)->first()->price;
    $orderId =  Order::create([
        'merchant_id'=>$user->id,
        'name'=>$package->name,
        'package_id'=>$package->id,
        'cost'=>$package->cost,
        'card_price'=>$package->card_price,
        'payment_method'=>$payment_method,
        'merchant_price'=>$new_price,
        'transaction_id'=>$transaction_id,
        'count'=>$count,
        'total'=>$package->card_price * $count,
        'status'=>1,
        'paid_order'=>$payment_method == "wallet" ?  "paid" :"not_paid",
        'image'=>$package->category->company->image,
        'color'=>$package->category->company->color,
        'api_linked'=>1,
        'cart_type'=>"stc",
        'company_name'=>$package->category->company->name,
        'description'=>$package->category->description,
    ]);
    for($i=1;$i<=$count;$i++){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.qwik.channels.com.sa/order-services/external-pin-sales?modifiedData=SALE',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                    "productId": "'.($product_id).'",
                    "requestSrvrTime": "'.$today.'",
                    "terminalId": "'.$api_terminal_id.'",
                    "username": "'.$api_username.'",
                    "password": "'.$api_password.'",
                    "trxId": "'.gen_uuid().'"
                }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        if(!empty($response)){
            $parsedJSON = json_decode($response);
            if($parsedJSON->status == 200){
                /**/


                $request['merchant_id']=  $user->id;
                /**/
                $cardPIN = $parsedJSON->pinDetail->pin;
                $cardSERIAL = $parsedJSON->pinDetail->serial;
                $cardVALIDTO = $parsedJSON->pinDetail->validTill;
                $time = strtotime($cardVALIDTO);
                $order =  Order::create([
                    'parent_id'=>$orderId->id,
                    'merchant_id'=>$user->id,
                    'name'=>$package->name,
                    'package_id'=>$package->id,
                    'card_number'=>$cardPIN,
                    'serial_number'=>$cardSERIAL,
                    'cost'=>$package->cost,
                    'card_price'=>$package->card_price,
                    'payment_method'=>$payment_method,
                    'merchant_price'=>$new_price,
                    'transaction_id'=>$transaction_id,
                    'end_date'=>date('Y-m-d',$time),
                    'count'=>1,
                    'status'=>1,
                    'image'=>$package->category->company->image,
                    'color'=>$package->category->company->color,
                    'api_linked'=>1,
                    'cart_type'=>"stc",
                    'company_name'=>$package->category->company->name,
                    'description'=>$package->category->description,
                ]);
                $newCard = \App\Models\Card::create([
                    'card_number'     => $cardPIN,
                    'serial_number'    => $cardSERIAL,
                    'end_date' =>date('Y-m-d',$time),
                    'package_id' => $package->id,
                    'sold'=>1,
                    'cart_type'=>"stc",
                ]);
                if ($payment_method == "wallet"){
                    store_qwik_sales($user,$package,$new_price,$order,$payment_method);
                }
                DB::commit(); // all good
                $cards[] = $newCard;
            }else{
                return "error";
            }
        }
        curl_close($curl);
    }
    $data = [
        'gencode' => $package->gencode,
        'total_price'=>(string)($package->card_price * $count),
        'order_id'=>$orderId->id,
//        'merchant'=>[
//            'id'=>$user->id,
//            'name'=>$user->name
//        ],
//        'package_name'                 => $package->name[app()->getLocale()],
//        'category_name'                 => $package->category->name[app()->getLocale()],
//        'description'                 => $package->category->description[app()->getLocale()],
//        'company_name'                 => $package->category->company->name[app()->getLocale()],
//        'price'      =>(string)$package->card_price,
//        'merchant_price'      =>(string)$new_price,
//        'cards'=> CardResource::collection($cards)
    ];
    return ApiController::respondWithSuccess($data);




}



function store_qwik_sales($merchant,$package,$new_price,$order,$payment_method)
{
    try {

        if ($payment_method == "online" ){
            $percentage = $merchant->geidea_percentage ? $merchant->geidea_percentage : settings()->geidea_percentage;

            $get_commission = $package->card_price * $percentage ;
            $statistics = \App\Models\Statistic::find(1);
            $statistics->update([
                'geidea_commission' => $statistics->geidea_commission + $get_commission
            ]);
            $result = ($package->card_price - $new_price) - $get_commission;
            $profit = $merchant->profits + $result;
        }else{
            $profit = $merchant->profits + ($package->card_price - $new_price);
        }
        $transfer = \Modules\Transfers\Entities\Transfer::create([
            'userable_id'=>$merchant->id,
            'order_id'=>$order->id,
            'userable_type'=>get_class($merchant),
            'type'=>"sales",
            'geidea_commission'=> $payment_method == "online" ? $get_commission : null,
            'geidea_percentage'=>$payment_method == "online" ? $percentage : 0,
            'api_linked'=>1,//api linked
            'cart_type'=>"stc",
            'amount'=>$package->card_price,
            'profits'=>$payment_method == "online"  ? $result   : ($package->card_price - $new_price),
            'profits_total'=>$profit,
            'balance_total'=>$payment_method == "online" ?   $merchant->balance : $merchant->balance - $package->card_price,
        ]);
        updateTransfer($transfer,$merchant);
        $merchant->update([
            'balance'=> $payment_method == "online" ? $merchant->balance : $merchant->balance - $package->card_price,
            'sales'=>$merchant->sales + $package->card_price,
            'profits'=>$profit,
        ]);
        DB::commit(); // all good
        return $transfer;
    } catch (\Exception $exception) {
        return ApiController::respondWithError(trans('api.500'));
    }
}
function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}
