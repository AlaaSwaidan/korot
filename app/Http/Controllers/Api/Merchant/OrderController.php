<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Merchant\AddOrderRequest;
use App\Http\Requests\Api\Merchant\ChangeStatusCardRequest;
use App\Http\Requests\Api\Merchant\ChangeStatusOrderRequest;
use App\Http\Requests\Api\Merchant\RedirectPaymentRequest;
use App\Http\Resources\Api\Merchant\CardResource;
use App\Http\Resources\Api\Merchant\MyOrderResource;
use App\Http\Resources\Api\Merchant\OrderResource;
use App\Mail\SendAdminMail;
use App\Models\Card;
use App\Models\Order;
use App\Models\Package;
use App\Services\TwelveApiService;
use App\Services\ZainService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Transfers\Entities\Transfer;

class OrderController extends Controller
{
    //
    public $user;
    public function __construct()
    {
        $this->user = auth()->guard('api_merchant')->user();
    }
    public function change_order_print_status(ChangeStatusOrderRequest $request){

        $orders = Order::where('parent_id',$request->order_id)->update([
            'print_status'=>$request->print_status
        ]);
        $order = Order::find($request->order_id);
        $data = new OrderResource($order);
        return ApiController::respondWithSuccess($data);
    }
    public function change_card_print_status(ChangeStatusCardRequest $request){
        $order = Order::find($request->card_id);
        $order->update($request->all());
        $data = new OrderResource($order);
        return ApiController::respondWithSuccess($data);
    }
    // Helper function to mark cards as sold
    private function markCardsAsSold($cards)
    {
        foreach ($cards as $card) {
            $card->update(['sold' => 1]);
        }
    }
    // Helper function to mark cards as sold
    private function markCardsAsNOTSold($cards)
    {
        foreach ($cards as $card) {
            $card->update(['sold' => 0]);
        }
    }
    public function add_order(AddOrderRequest $request){

        try {
            $retryAttempts = 3; // Number of retry attempts
     return retry($retryAttempts, function () use ($request) {
            // Start a database transaction
            DB::beginTransaction();
            $package = Package::find($request->package_id);
          $card = $package->cards()->where('sold',0)->lockForUpdate()->get();

          if ($package->gencode != null && $package->gencode_status == 1  && $card->where('sold',0)->count() == 0){

             //api_linked for transfers table and orders
              if ($request->payment_method == "wallet"){
                  $result = $this->check_balance($this->user , $request->count , $package);
                  if ($result == 0) return ApiController::respondWithError(trans('api.Your_balance_is_not_enough'));
                  $get_return_data = create_qwik_order($package->gencode,$request->count,$package,$this->user,$request->payment_method);
                  if ($get_return_data == "error"){
                      return ApiController::respondWithError(trans('api.error_order'));

                  }else{

                      return $get_return_data;
                  }
              }else if ($request->payment_method == "online"){
                  //api_linked for transfers table and orders
                  $get_return_data = create_qwik_order($package->gencode,$request->count,$package,$this->user,"online",$request->transaction_id);
                  if ($get_return_data == "error"){
                      return ApiController::respondWithError(trans('api.error_order'));

                  }else{
                      return $get_return_data;
                  }
              }


          }
          elseif ($package->gencode_like_card != null && $package->gencode_like_card_status == 1  && $card->where('sold',0)->count() == 0){

             //api_linked for transfers table and orders
              if ($request->payment_method == "wallet"){
                  $result = $this->check_balance($this->user , $request->count , $package);
                  if ($result == 0) return ApiController::respondWithError(trans('api.Your_balance_is_not_enough'));
                  $get_return_data = create_order($package->gencode_like_card,$request->count,$package,$this->user,$request->payment_method);
                  if (isset($get_return_data['error']) && $get_return_data['error'] == "error"){
                      return ApiController::respondWithError($get_return_data['message']);

                  }else{
                      return ApiController::respondWithSuccess($get_return_data);
                  }
              }
              else  if ($request->payment_method == "online"){
                  //api_linked for transfers table and orders
                  $get_return_data = create_order($package->gencode_like_card,$request->count,$package,$this->user,"online",$request->transaction_id);
                  if (isset($get_return_data['error']) && $get_return_data['error'] == "error"){
                      return ApiController::respondWithError($get_return_data['message']);

                  }else{
                      return ApiController::respondWithSuccess($get_return_data);
                  }
              }

          }
          elseif ($package->product_id_zain != null && $package->zain_status == 1  && $card->where('sold',0)->count() == 0){

             //api_linked for transfers table and orders
              if ($request->payment_method == "wallet"){
                  $result = $this->check_balance($this->user , $request->count , $package);
                  if ($result == 0) return ApiController::respondWithError(trans('api.Your_balance_is_not_enough'));
                  $get_return_data =  self::pinPrinting($package->product_id_zain,$request->count,$package,$this->user,$request->payment_method);
                  if ($get_return_data == "error"){
                      return ApiController::respondWithError(trans('api.error_order'));

                  }else{
                      return $get_return_data;
                  }
              }
              else  if ($request->payment_method == "online"){
                  //api_linked for transfers table and orders
                  $get_return_data = self::pinPrinting($package->product_id_zain,$request->count,$package,$this->user,"online",$request->transaction_id);
                  if ($get_return_data == "error"){
                      return ApiController::respondWithError(trans('api.error_order'));

                  }else{
                      return $get_return_data;
                  }
              }

          }
          elseif ($package->package_id_twelve != null && $package->twelve_status == 1  && $card->where('sold',0)->count() == 0){

             //api_linked for transfers table and orders
              if ($request->payment_method == "wallet"){
                  $result = $this->check_balance($this->user , $request->count , $package);
                  if ($result == 0) return ApiController::respondWithError(trans('api.Your_balance_is_not_enough'));
                  $get_return_data =  self::pinPrinting($package->package_id_twelve,$request->count,$package,$this->user,$request->payment_method);
                  if ($get_return_data == "error"){
                      return ApiController::respondWithError(trans('api.error_order'));

                  }else{
                      return $get_return_data;
                  }
              }
              else  if ($request->payment_method == "online"){
                  //api_linked for transfers table and orders
                  $get_return_data = self::pinPrinting($package->product_id_zain,$request->count,$package,$this->user,"online",$request->transaction_id);
                  if ($get_return_data == "error"){
                      return ApiController::respondWithError(trans('api.error_order'));

                  }else{
                      return $get_return_data;
                  }
              }

          }
          elseif ($card->count() < $request->count){
              return ApiController::respondWithError(trans('api.not_available_count'));
          }else{
              $get_cards = $card->take($request->count);
              // Mark the selected cards as sold
              $this->markCardsAsSold($get_cards);

              if ($new_price =$this->user->prices()->where('package_id',$package->id)->where('type',$this->user->type)->first()){
                  $merchant_price = $new_price->price;
              }


              $new_price = isset($merchant_price) ? $merchant_price :  $package->prices()->where('type',$this->user->type)->first()->price;
              $data = [
                  'gencode' => "",
                  'total_price'=>(string)($package->card_price * $request->count),
//                  'merchant'=>[
//                      'id'=>$this->user->id,
//                      'name'=>$this->user->name
//                  ],
//                  'package_name'                 => $package->name[app()->getLocale()],
//                  'category_name'                 => $package->category->name[app()->getLocale()],
//                  'description'                 => $package->category->description[app()->getLocale()],
//                  'company_name'                 => $package->category->company->name[app()->getLocale()],
//                  'price'      =>(string)$package->card_price,
//                  'merchant_price'      =>(string)$new_price,
//                  'cards'=>  CardResource::collection($get_cards)
              ];


              if ($request->payment_method == "wallet"){
                  $result = $this->check_balance($this->user , $request->count , $package);
                  if ($result == 0){
                      $this->markCardsAsNotSold($get_cards);
                      return  ApiController::respondWithError(trans('api.Your_balance_is_not_enough'));
                  }
                  return $this->pay_wallet($package,$request,$get_cards,$data);
              }else if ($request->payment_method == "online"){
                  $data = [
                      'gencode' => "",
                      'total_price'=>(string)($package->card_price * $request->count),
//                      'merchant'=>[
//                          'id'=>$this->user->id,
//                          'name'=>$this->user->name
//                      ],
//                      'package_name'                 => $package->name[app()->getLocale()],
//                      'category_name'                 => $package->category->name[app()->getLocale()],
//                      'description'                 => $package->category->description[app()->getLocale()],
//                      'company_name'                 => $package->category->company->name[app()->getLocale()],
//                      'price'      =>(string)$package->card_price,
//                      'merchant_price'      =>(string)$new_price,
//                      'cards'=>  CardResource::collection($get_cards)
                  ];
                  return $this->pay_store_online($package,$request,$get_cards,$data);
//                  return ApiController::respondWithSuccess($data);
              }


          }
       }, 300); // Retry every 300 milliseconds
        } catch (\Exception $e) {
            // Roll back the transaction in case of an exception
            Log::error('Error adding order: ' . $e->getMessage());
            DB::rollBack();

            // Handle exceptions
            return ApiController::respondWithError("code status is: " . $e->getCode() . " error message: " . $e->getMessage());
        }
    }

    public function pay_store_online($package,$request,$get_cards,$data){
        if ($new_price =$this->user->prices()->where('package_id',$package->id)->where('type',$this->user->type)->first()){
            $merchant_price = $new_price->price;
        }

        $new_price = isset($merchant_price) ? $merchant_price :  $package->prices()->where('type',$this->user->type)->first()->price;
        $request['merchant_id']=  $this->user->id;
        $request['name']=$package->name;
        $request['package_id']=$package->id;
        $request['description']=$package->category->description;
        $request['card_price']=$package->card_price;
        $request['cost']=$package->cost;
        $request['status']=1;
        $request['merchant_price']=$new_price;
        $request['image']=$package->category->company->image;
        $request['company_name']=$package->category->company->name;
        $request['color']=$package->category->company->color;
        $total = $package->card_price * $request->count;
        $request['total']=$total;
        $request['paid_order']="not_paid";
        $orderId =  Order::create($request->all());
        foreach ($get_cards as $value){
            $request['card_number']= $value->card_number;
            $request['serial_number']= $value->serial_number;
            $request['end_date']= $value->end_date;
            $request['payment_method']= "online";
            $request['count']= 1;
            $request['cart_type']= $value->cart_type;
            $value->update([
                'sold'=>1
            ]);
            $request['parent_id']=$orderId->id;
            $order =  Order::create($request->all());
//            $this->store_sales($request,$this->user,$package,$new_price,$order,'online');

        }
        $data +=[
            'order_id'=>$orderId->id
        ];
        DB::commit(); // all good
        return ApiController::respondWithSuccess($data);
    }

    public function confirm_payment(RedirectPaymentRequest $request){


        if ($request->status == "paid"){
            foreach ($request->order_id as $key => $value){
                $order = Order::find($value);
                if ($order->paid_order == "paid"){
                    return ApiController::respondWithError(trans('api.successfully_paid'));
                }
                $orders = Order::where('parent_id',$value)->get();
                foreach ($orders as $item){
                    $request['card_number']= $item->card_number;
                    $request['serial_number']= $item->serial_number;
                    $request['end_date']= $item->end_date;
                    $request['payment_method']= "online";
                    $request['count']= 1;
                    $item->update([
                        'transaction_id'=>$request->transaction_id,
                        'paid_order'=>"paid"
                    ]);
                    $package = Package::find($item->package_id);
                    $this->store_sales($request,$this->user,$package,$item->merchant_price,$item,'online');
                }

                $order->update([
                    'transaction_id'=>$request->transaction_id[$key],
                    'paid_order'=>"paid"
                ]);
                /*محفظة جيديا */
                add_geadia($this->user,$order->total,"order",null,$request->transaction_id[$key]);
            }

        }
//        else{
//            foreach ($request->order_id as $key => $value){
//                $order = Order::find($value);
//                $orders = Order::where('parent_id',$value)->get();
//                foreach ($orders as $item){
//                    $cards = Card::where('package_id',$item->package_id)
//                        ->where('card_number',$item->card_number)
//                        ->where('serial_number',$item->serial_number)
//                        ->first();
//                    $cards->update([
//                        'sold'=>0
//                    ]);
//                }
//                $order->delete();
//            }
//
//        }
        return response()->json(['success'=> true,'status' => 200 , 'data'=>null , 'message'=>null])->setStatusCode(200);;

    }
    public function pay_wallet($package,$request,$get_cards,$data,$merchant_price = null){
        if ($new_price =$this->user->prices()->where('package_id',$package->id)->where('type',$this->user->type)->first()){
            $merchant_price = $new_price->price;
        }
        $new_price = isset($merchant_price) ? $merchant_price :  $package->prices()->where('type',$this->user->type)->first()->price;
        $request['merchant_id']=  $this->user->id;
        $request['name']=$package->name;
        $request['package_id']=$package->id;
        $request['description']=$package->category->description;
        $request['card_price']=$package->card_price;
        $request['cost']=$package->cost;
        $request['status']=1;
        $request['api_linked']=0;

        $request['merchant_price']=$new_price;
        $request['image']=$package->category->company->image;
        $request['company_name']=$package->category->company->name;
        $request['color']=$package->category->company->color;
        $request['total']=$package->card_price * $request->count;
        $orderId =  Order::create($request->all());
        foreach ($get_cards as $value){
            $request['card_number']= $value->card_number;
            $request['serial_number']= $value->serial_number;
            $request['end_date']= $value->end_date;
            $request['count']= 1;
            $request['cart_type']=$value->cart_type;
            $value->update([
                'sold'=>1
            ]);
            $request['parent_id']=$orderId->id;
            $order =  Order::create($request->all());
            $this->store_sales($request,$this->user,$package,$new_price,$order,'wallet');

        }
        $data +=[
            'order_id'=>$orderId->id
        ];
        DB::commit(); // all good
        return ApiController::respondWithSuccess($data);
    }
    public function my_orders(Request $request){
        $orders = $this->user->orders()->where('parent_id',null);
        if ($request->type == "last_week"){
            $orders = $orders->whereBetween('created_at',
                [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
            );
        }
        if ($request->type == "today"){
            $orders = $orders->whereDate(
                'created_at', '=', Carbon::now()
            );

        }
        if ($request->type == "yesterday"){
            $orders = $orders->whereDate('created_at', '=', Carbon::now()->subDay());
        }
        if ($request->type == "exact_time"){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);
            $orders = $orders->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }
        $orders = $orders->orderBy('id','desc')->where('status',1)->paginate(20);
        MyOrderResource::collection($orders);


//        OrderResource::collection($orders);
        return ApiController::respondWithSuccess($orders);

    }
    public function order_details($id){
        $orders = Order::find($id);
        if (! $orders){
            return ApiController::respondWithServerError();
        }
        if ($orders->paid_order == "cancel"){
            return ApiController::respondWithError(trans('api.cancel'));
        }

        $data = new OrderResource($orders);
        return ApiController::respondWithSuccess($data);

    }
    public function store_sales($request,$merchant,$package,$new_price,$order,$payment)
    {
        try {
            if ($payment == "online" ){

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
             'geidea_commission'=> $payment == "online" ? $get_commission : null,
             'geidea_percentage'=>$payment == "online" ? $percentage : 0,
             'amount'=>$package->card_price,
             'api_linked'=>$order->api_linked,
             'cart_type'=>$order->cart_type,
             'profits'=>$payment == "online"  ? $result   : ($package->card_price - $new_price),
             'profits_total'=>$profit,
             'balance_total'=>$payment == "online" ?  $merchant->balance : $merchant->balance - $package->card_price,
            ]);

            updateTransfer($transfer,$merchant);
            $merchant->update([
                'balance'=>$payment == "online" ? $merchant->balance  : $merchant->balance - $package->card_price,
                'sales'=>$merchant->sales + $package->card_price,
                'profits'=>$profit,
            ]);
            return $transfer;
        } catch (\Exception $exception) {
            return ApiController::respondWithError(trans('api.500'));
        }
    }

    public function check_balance($merchant,$cards,$package){
        if ($merchant->balance < ($package->card_price * $cards)){
            return 0;
        }
        return 1;
    }

/* zain order*/
    public static function pinPrinting($product_id_zain,$count,$package,$user,$payment_method, $transaction_id = null )
    {
        $productId = $product_id_zain; // 30 SAR voucher
        $amount = $package->price_zain * 100 ; // 30 SAR × 100
        $cashier = \request()->input('cashier', 'Ahmed');
        $results = [];

        for ($i = 1; $i <= $count; $i++) {
            $zain = new ZainService();
            $xml = $zain->buildPinPrintingXml($productId, $amount, $cashier);
            $response = $zain->sendRequest($xml);

            if (strpos($response, '<') !== 0) {
                $results[] = [
                    'index' => $i,
                    'error' => 'Invalid XML response',
                    'raw' => $response,
                ];
                continue;
            }

            $parsed = simplexml_load_string($response);
            if ($parsed->RESULT != "0") {
                return "error";
            }
            $results[] = [
                'index' => $i,
                'raw_response' => $response,
                'result' => (string)($parsed->RESULT ?? ''),
                'result_text' => (string)($parsed->RESULTTEXT ?? ''),
                'pin' => (string)($parsed->PINCREDENTIALS->PIN ?? ''),
                'serial' => (string)($parsed->PINCREDENTIALS->SERIAL ?? ''),
                'valid_to' => (string)($parsed->PINCREDENTIALS->VALIDTO ?? ''),
            ];
        }
        $get_data = self::createOrder($product_id_zain,$count,$package,$user,$payment_method, $transaction_id);
        $orderId = $get_data->orderId;
        $new_price = $get_data->new_price;
        foreach ($results as $result) {
            $order =  Order::create([
                'parent_id'=>$orderId->id,
                'merchant_id'=>$user->id,
                'name'=>$package->name,
                'package_id'=>$package->id,
                'card_number'=>$result['pin'],
                'serial_number'=>$result['serial'],
                'cost'=>$package->cost,
                'total'=>$package->card_price * $count,
                'card_price'=>$package->card_price,
                'payment_method'=>$payment_method,
                'merchant_price'=>$new_price,
                'transaction_id'=>$transaction_id,
                'end_date'=>$result['valid_to'],
                'count'=>1,
                'status'=>1,
                'image'=>$package->category->company->image,
                'color'=>$package->category->company->color,
                'api_linked'=>1,
                'cart_type'=>"zain",
                'company_name'=>$package->category->company->name,
                'description'=>$package->category->description,
            ]);
            $card = Card::create([
                'card_number'=>$result['pin'],
                'serial_number'=>$result['serial'],
                'end_date'=>$result['valid_to'],
                'package_id' => $package->id,
                'sold'=>1,
                'cart_type'=>"zain",
            ]);
            if ($payment_method == "wallet"){
                self::storeSaleZain($user,$package,$new_price,$order,$payment_method);
            }
        }

        DB::commit(); // all good
        $data = [
            'gencode' => $package->product_id_zain,
            'total_price'=>(string)($package->card_price * $count),
            'order_id'=>$orderId->id,
            ];
        return ApiController::respondWithSuccess($data);
    }
    /*twelve*/
    public static function twelve_package($package_id_twelve,$count,$package,$user,$payment_method, $transaction_id = null )
    {
        $productId = $package_id_twelve; // 30 SAR voucher

        $results = [];

        for ($i = 1; $i <= $count; $i++) {
            $response = (new TwelveApiService())->purchaseVoucher(
                $productId,
                $package->id.randNumber(4)
            );
            if ($response['success'] == false) {
                return "error";
            }

            $results[] = [
                'index' => $i,
                'code' => $response['codes'][0]['code'],
                'serialNumber' =>$response['codes'][0]['serialNumber'],
            ];
        }
        $get_data = self::createTwelveOrder($package_id_twelve,$count,$package,$user,$payment_method, $transaction_id);
        $orderId = $get_data->orderId;
        $new_price = $get_data->new_price;
        foreach ($results as $result) {
            $order =  Order::create([
                'parent_id'=>$orderId->id,
                'merchant_id'=>$user->id,
                'name'=>$package->name,
                'package_id'=>$package->id,
                'card_number'=>$result['code'],
                'serial_number'=>$result['serialNumber'],
                'cost'=>$package->cost,
                'total'=>$package->card_price * $count,
                'card_price'=>$package->card_price,
                'payment_method'=>$payment_method,
                'merchant_price'=>$new_price,
                'transaction_id'=>$transaction_id,
                'end_date'=>Carbon::now()->addYear(),
                'count'=>1,
                'status'=>1,
                'image'=>$package->category->company->image,
                'color'=>$package->category->company->color,
                'api_linked'=>1,
                'cart_type'=>"twelve",
                'company_name'=>$package->category->company->name,
                'description'=>$package->category->description,
            ]);
            $card = Card::create([
                'card_number'=>$result['code'],
                'serial_number'=>$result['serialNumber'],
                'end_date'=>Carbon::now()->addYear(),
                'package_id' => $package->id,
                'sold'=>1,
                'cart_type'=>"twelve",
            ]);
            if ($payment_method == "wallet"){
                self::storeSaleTwelve($user,$package,$new_price,$order,$payment_method);
            }
        }

        DB::commit(); // all good
        $data = [
            'gencode' => $package->package_id_twelve,
            'total_price'=>(string)($package->card_price * $count),
            'order_id'=>$orderId->id,
            ];
        return ApiController::respondWithSuccess($data);
    }
    public static function createOrder($product_id_zain,$count,$package,$user,$payment_method, $transaction_id = null){
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
            'total'=>$package->card_price * $count,
            'payment_method'=>$payment_method,
            'merchant_price'=>$new_price,
            'transaction_id'=>$transaction_id,
            'count'=>$count,
            'status'=>1,
            'image'=>$package->category->company->image,
            'color'=>$package->category->company->color,
            'api_linked'=>1,
            'cart_type'=>"zain",
            'paid_order'=>$payment_method == "wallet" ?  "paid" :"not_paid",
            'company_name'=>$package->category->company->name,
            'description'=>$package->category->description,
        ]);
        return (object)['orderId'=>$orderId , 'new_price'=>$new_price];
    }
    public static function createTwelveOrder($package_id_twelve,$count,$package,$user,$payment_method, $transaction_id = null){
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
            'total'=>$package->card_price * $count,
            'payment_method'=>$payment_method,
            'merchant_price'=>$new_price,
            'transaction_id'=>$transaction_id,
            'count'=>$count,
            'status'=>1,
            'image'=>$package->category->company->image,
            'color'=>$package->category->company->color,
            'api_linked'=>1,
            'cart_type'=>"twelve",
            'paid_order'=>$payment_method == "wallet" ?  "paid" :"not_paid",
            'company_name'=>$package->category->company->name,
            'description'=>$package->category->description,
        ]);
        return (object)['orderId'=>$orderId , 'new_price'=>$new_price];
    }


   public static function storeSaleTwelve($merchant,$package,$new_price,$order,$payment_method)
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
                    'cart_type'=>"twelve",
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
   public static function storeSaleZain($merchant,$package,$new_price,$order,$payment_method)
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
                    'cart_type'=>"zain",
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

}
