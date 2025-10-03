<?php

namespace App\Http\Controllers\Api;




use App\Exports\WalletsExport;
use App\Http\Resources\Api\Merchant\MyOrderResource;
use App\Models\Card;
use App\Models\Distributor;
use App\Models\Order;
use App\Models\UserDevice;
use App\Models\UserToken;
use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Transfers\Entities\Transfer;
use Tymon\JWTAuth\Facades\JWTAuth;

use Validator;
use Maatwebsite\Excel\Facades\Excel;

class ApiController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.verify')->only('createUserToken');

    }

    public function my_orders(Request $request){


//           $wallets = Wallet::with('merchant', 'transfer')
//             ->whereHas('transfer', function($q){
//                 $q->whereColumn('wallets.balance', 'transfers.amount');
//             })
//             ->whereBetween(DB::raw('DATE(wallets.created_at)'), ['2025-08-01', '2025-08-31'])
//             ->get();
// //        dd($wallets);

//         foreach ($wallets as $wallet) {
//             $geideaCommission = $wallet->transfer->geidea_commission;

//             // Update wallet balances
//             $wallet->balance -= $geideaCommission;
//             $wallet->current_balance -= $geideaCommission;
//             $wallet->save();

//             // Update merchant balance
//             $wallet->merchant->decrement('balance', $geideaCommission);
//             $wallet->transfer->decrement('balance_total', $geideaCommission);
//         }
//             dd('done');


//        $ids = Wallet::whereBetween(DB::raw('DATE(created_at)'), ["2025-01-01", "2025-10-30"])->get();
        return Excel::download(new WalletsExport(), 'wallet_report.xlsx');
//        $wallets = DB::table('wallets')
//            ->join('transfers', 'wallets.transfer_id', '=', 'transfers.id')
//            ->join('merchants', 'wallets.merchant_id', '=', 'merchants.id')
//            ->whereBetween(DB::raw('DATE(wallets.created_at)'), ['2025-09-01', '2025-10-30'])
//            ->whereColumn('wallets.balance', 'transfers.amount')
//            ->select('merchants.name as user_name', 'wallets.balance as wallet_balance', 'merchants.balance as current_balance')
//            ->get();

        Excel::create('wallet_report', function($excel) use ($wallets) {
            $excel->sheet('Sheet 1', function($sheet) use ($wallets) {
                $sheet->fromArray($wallets);
            });
        })->download('xlsx');
        dd($wallets);
        return ApiController::respondWithSuccess($orders);

    }

    public function terms_conditions(){
        $settings = settings()->terms[app()->getLocale()];
        $data =[
            'terms'=>$settings
        ];
        return self::respondWithSuccess($data);
    }
    public function update_version(){
        $settings = settings();
        $data =[
            'current_version'=>$settings->current_version,
            'force_update'=>$settings->version_status ? true : false,
            'version_date'=>$settings->version_date,
            'version_apk_link'=>$settings->version_apk_link,
        ];
        return self::respondWithSuccess($data);
    }
    public function shutdown_app(){
        $settings = settings();
        $data =[
            'shutdown_app'=>$settings->shutdown_app ? true : false,
        ];
        return self::respondWithSuccess($data);
    }
    public function distributor_update_version(){
        $settings = settings();
        $data =[
            'current_version'=>$settings->distributor_current_version,
            'force_update'=>$settings->distributor_version_status ? true : false,
            'version_date'=>$settings->distributor_version_date,
            'version_apk_link'=>$settings->distributor_version_apk_link,
        ];
        return self::respondWithSuccess($data);
    }

    public static function createUserDeviceToken($user, $deviceToken, $deviceType) {

        if (! UserDevice::where('device_identifier',$deviceType)->where('firebase_token',$deviceToken)->where('userable_id',$user->id)
            ->where('userable_type',get_class($user))->first()){
            $created = UserDevice::create(['userable_id' => $user->id,'userable_type'=>get_class($user), 'device_identifier' => $deviceType, 'firebase_token' => $deviceToken]);
            return $created;
        }

    }
    public static function createUserToken($user, $device_id) {

        $get_token = UserToken::where('userable_id', $user->id)
            ->where('userable_type',get_class($user))
            ->orderBy('id', 'desc')
            ->first();
        if($get_token ){
            JWTAuth::manager()->invalidate(new \Tymon\JWTAuth\Token($get_token->access_token), $forceForever = false);
            UserToken::where('userable_id', $user->id)
                ->where('userable_type',get_class($user))
                ->delete();
        }


        $token = generateApiToken($user);
        DB::table('user_tokens')->insert([
            'userable_id' => $user->id,
            'userable_type'=>get_class($user),
            'device_id' => $device_id,
            'access_token' => $token
        ]);
        return $token;

    }

    public static function respondWithSuccess($data) {
        http_response_code(200);
        return response()->json(['success'=> true,'status' =>  http_response_code()  , 'data' => $data, 'message'=>null])->setStatusCode(200);
    }
    public static function respondWithSuccessMessage($data) {
        http_response_code(200);
        return response()->json(['success'=> true,'status' =>  http_response_code(), 'data' =>null , 'message'=> $data])->setStatusCode(200);
    }


    public static function respondWithError($errors) {
        http_response_code(422);  // set the code
        return response()->json(['success'=> false,'status' =>  http_response_code() , 'data' =>null,  'message' => $errors])->setStatusCode(422);
    }
    public static function respondWithErrorNOTFound($errors) {
        http_response_code(404);  // set the code
        return response()->json(['success'=> false,'status' =>  http_response_code()  , 'data' =>null, 'message' => $errors])->setStatusCode(404);
    }

    public static function respondWithErrorClient($errors) {
        http_response_code(400);  // set the code
        return response()->json(['success'=> false,'status' =>  http_response_code() , 'data' =>null,  'message' => $errors])->setStatusCode(400);
    }

    public static function respondWithErrorAuth($errors) {
        http_response_code(401);  // set the code
        return response()->json(['success'=> false,'status' =>  http_response_code(), 'data' =>null , 'message' => $errors])->setStatusCode(401);
    }


    public static function respondWithServerError() {
        $errors = trans('messages.error_500');
        http_response_code(500);
        return response()->json(['success'=> false,'status' =>  http_response_code(), 'data' =>null,  'message' => $errors])->setStatusCode(500);
    }

    public static function respondWithErrorAdmin($errors) {
        http_response_code(422);  // set the code
        return response()->json(['mainCode'=> 0,'code' =>  http_response_code()  , 'data' => null, 'message'=> '',  'error' => $errors])->setStatusCode(422);
    }


}
