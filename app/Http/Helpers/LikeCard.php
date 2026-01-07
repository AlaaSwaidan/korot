<?php

use App\Http\Controllers\Api\ApiController;
use App\Models\Card;
use App\Models\Journal;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Modules\Transfers\Entities\Transfer;
use App\Models\PurchaseOrder;
use App\Http\Controllers\Api\Merchant\OrderController;
use App\Http\Resources\Api\Merchant\CardResource;
function create_order($product_id,$count,$package,$user,$payment_method, $transaction_id = null){
    $curl = curl_init();
    $time= \Carbon\Carbon::now()->timestamp;
    $hash = $time;

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://taxes.like4app.com/online/create_order",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => array(
            'deviceId' => 'b42bdde70294758891a6590127ec802d37e9e1ee0473c45ee86bd14a1db35cda',
            'email' => '3lialmuslem@gmail.com',
            'password' => '18c5fd46f0d3ba3929b88feb9e1c4ebe8cd66a5db9a5dd3363f991c727530e5917b96f86a92c4742e9ce77c8a6cf59ec',
            'securityCode' => 'e8f8aca5140c40104f2ccdaf8909953d8f5184e66a43a6d04765fded11afe8e6',
            'langId' => '1',
            'quantity'=>$count,
            'productId' => $product_id, //376
            'referenceId' => 'Merchant_12467',
            'time' => $time,
            'hash' => generateHash($hash),
        ),

    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $data = json_decode($response);
  
    if (isset($data) && $data->response == 1){
        if ($new_price =$user->prices()->where('package_id',$package->id)->where('type',$user->type)->first()){
            $merchant_price = $new_price->price;
        }
        $new_price = isset($merchant_price) ? $merchant_price :  $package->prices()->where('type',$user->type)->first()->price;
        $request['merchant_id']=  $user->id;
        $all_ids=[];
        $orderId =  Order::create([
            'merchant_id'=>$user->id,
            'name'=>$package->name,
            'package_id'=>$package->id,
            'cost'=>$package->cost,
            'card_price'=>$package->card_price,
            'total'=>$package->card_price * $count,
            'payment_method'=>$payment_method,
            'merchant_price'=>$new_price,
            'transaction_id'=>$transaction_id,
            'count'=>$count,
            'status'=>1,
            'image'=>$package->category->company->image,
            'color'=>$package->category->company->color,
            'api_linked'=>1,
            'cart_type'=>"likecard",
            'paid_order'=>$payment_method == "wallet" ?  "paid" :"not_paid",
            'company_name'=>$package->category->company->name,
            'description'=>$package->category->description,
        ]);
        foreach ($data->serials as $value){
            $order =  Order::create([
                'parent_id'=>$orderId->id,
                'merchant_id'=>$user->id,
                'name'=>$package->name,
                'package_id'=>$package->id,
                'card_number'=>decryptSerial($value->serialCode),
                'serial_number'=>$value->serialNumber,
                'cost'=>$package->cost,
                'card_price'=>$package->card_price,
                'payment_method'=>$payment_method,
                'merchant_price'=>$new_price,
                'transaction_id'=>$transaction_id,
                'end_date'=>Carbon\Carbon::createFromFormat('d/m/Y', $value->validTo)->format('Y-m-d'),
                'count'=>1,
                'status'=>1,
                'image'=>$package->category->company->image,
                'color'=>$package->category->company->color,
                'api_linked'=>1,
                'cart_type'=>"likecard",
                'company_name'=>$package->category->company->name,
                'description'=>$package->category->description,
            ]);
             $card = \App\Models\Card::create([
                'card_number'     => decryptSerial($value->serialCode),
                'serial_number'    => $value->serialNumber,
                'end_date' =>Carbon\Carbon::createFromFormat('d/m/Y', $value->validTo)->format('Y-m-d'),
                'package_id' => $package->id,
                 'sold'=>1,
                'cart_type'=>"likecard",
            ]);
             if ($payment_method == "wallet"){
                 store_sales($user,$package,$new_price,$order,$payment_method);
             }

            array_push($all_ids,$card->id);
        }
        $data = [
            'gencode' => $package->gencode_like_card,
            'total_price'=>(string)($package->card_price * $count),
            'order_id'=>$orderId->id,
//            'merchant'=>[
//                'id'=>$user->id,
//                'name'=>$user->name
//            ],
//            'package_name'                 => $package->name[app()->getLocale()],
//            'category_name'                 => $package->category->name[app()->getLocale()],
//            'description'                 => $package->category->description[app()->getLocale()],
//            'company_name'                 => $package->category->company->name[app()->getLocale()],
//            'price'      =>(string)$package->card_price,
//            'merchant_price'      =>(string)$new_price,
//            'cards'=> CardResource::collection(Card::whereIn('id',$all_ids)->get())
        ];
        DB::commit(); // all good
        return ApiController::respondWithSuccess($data);

//        return $all_ids;
    }else{
        return ApiController::respondWithError(["error" =>"error" ,'message'=>$data->message]);
    }

}
function store_sales($merchant,$package,$new_price,$order,$payment_method)
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
        $transfer = Transfer::create([
            'userable_id'=>$merchant->id,
            'order_id'=>$order->id,
            'userable_type'=>get_class($merchant),
            'type'=>"sales",
            'api_linked'=>1,
            'cart_type'=>"likecard",
            'geidea_commission'=> $payment_method == "online" ? $get_commission : null,
            'geidea_percentage'=>$payment_method == "online" ? $percentage : 0,
            'amount'=>$package->card_price,
            'profits'=>$payment_method == "online"  ? $result   : ($package->card_price - $new_price),
            'profits_total'=>$profit,
            'balance_total'=>$payment_method == "online" ? $merchant->balance  : $merchant->balance - $package->card_price,
        ]);
        updateTransfer($transfer,$merchant);
        $merchant->update([
            'balance'=>$payment_method == "online" ? $merchant->balance : $merchant->balance - $package->card_price,
            'sales'=>$merchant->sales + $package->card_price,
            'profits'=>$profit,
        ]);
        DB::commit(); // all good
        return $transfer;
    } catch (\Exception $exception) {
        return ApiController::respondWithError(trans('api.500'));
    }
}
function generateHash($time){
    $email = strtolower('3lialmuslem@gmail.com');
    $phone = '0542277779';
    $key = '8Tyr4EDw!2sN';
    return hash('sha256',$time.$email.$phone.$key);
}
function decryptSerial($encrypted_txt){
    $secret_key = 't-3zafRa';
    $secret_iv = 'St@cE4eZ';
    $encrypt_method = 'AES-256-CBC';
    $key = hash('sha256', $secret_key);

    //iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    return openssl_decrypt(base64_decode($encrypted_txt), $encrypt_method, $key, 0, $iv);
}
