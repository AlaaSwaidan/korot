<?php

namespace App\Http\Controllers\Api\Merchant;


use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Merchant\ConfirmForgetPasswordRequest;
use App\Http\Requests\Api\Merchant\ConfirmRegisterRequest;
use App\Http\Requests\Api\Merchant\ForgetPasswordRequest;
use App\Http\Requests\Api\Merchant\LoginRequest;
use App\Http\Requests\Api\Merchant\LogoutRequest;
use App\Http\Requests\Api\Merchant\RegisterRequest;
use App\Http\Requests\Api\Merchant\ResetPasswordRequest;
use App\Http\Resources\Api\Merchant\LoginResource;
use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\UserDevice;
use App\Models\UserToken;
use Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(LoginRequest $request){

        $check = Merchant::where(function ($q) use($request){
            $q->where('phone',$request->email_or_phone)
                ->orWhere('email',$request->email_or_phone);
        })->first();
         if ($check && Hash::check($request->password, $check->password)) {
             if ($check->tokens()->exists()) {
                 $token = $check->tokens()->orderBy('id','desc')->first();
                 $isValid = JWTAuth::setToken($token->access_token)->check();
                 if ($isValid)  return ApiController::respondWithErrorAuth(trans('api.logged_before'));
             }
            if ($check->confirmed == 0){
                $code = 1111;
                $check->update([
                    'confirm_code'=>$code
                ]);
                //send sms
                $data =  new LoginResource($check,'') ;
                return $data
                    ? ApiController::respondWithSuccess($data)
                    : ApiController::respondWithServerError();
            }
            if ($check->approve == 0){
                $errors = trans('api.Sorry_your_membership_wasnt_approved_by_Management');
                return ApiController::respondWithError($errors);
            }
            if ($check->active == 0){
                $errors = trans('api.Sorry_your_membership_was_stopped_by_Management');
                return ApiController::respondWithError($errors);
            }
            //save_firebase_token....
            $created = ApiController::createUserDeviceToken($check, $request->firebase_token, $request->device_identifier);
            $token = ApiController::createUserToken($check,  $request->device_identifier);


            $data =  new LoginResource($check,$token) ;
            return $data
                ? ApiController::respondWithSuccess($data)
                : ApiController::respondWithServerError();

        }else{
            $errors = trans('api.wrong_credential');
            return ApiController::respondWithError($errors);
        }

    }
    public function register(RegisterRequest $request) {
        $request['confirmed']=0;
        $request['added_by_type']="app";
        //send sms
        $code = 1111;
        $request['confirm_code']=$code;
        $request['commercial_image']= UploadImage($request->file('commercial_photo'), 'merchant', '/uploads/merchants');
        $create = Merchant::create($request->all());
        //save_firebase_token....
         ApiController::createUserDeviceToken($create, $request->firebase_token, $request->device_identifier);
        $data = new LoginResource($create,'');
        return ApiController::respondWithSuccess($data);

    }
    public function confirm_register(ConfirmRegisterRequest $request) {
            $check =Merchant::where('id',$request->id)->whereConfirmCode($request->confirm_code)->first();
            if ($check){
                $check->update([
                    'confirm_code'=>null,
                    'confirmed'=>1,
                ]);
                return ApiController::respondWithSuccessMessage(trans('api.admin_approved'));
            }
            return  ApiController::respondWithError(trans('api.error_code'));
    }

    public function forgetPassword(ForgetPasswordRequest $request) {
        $check = Merchant::where(function ($q) use($request){
            $q->where('phone',$request->email_or_phone)
                ->orWhere('email',$request->email_or_phone);
        })->first();

        if($check) {
            $code = 1111;
            $request['code']=$code;
            $updated=   $check->update([
                'confirm_code'=>$code,
            ]);
//            $this->send_sms($data);
            return $updated
                ? response()->json(['success'=> true,'status' =>  http_response_code() , 'data'=>null , 'message'=>null])->setStatusCode(200)
                : ApiController::respondWithServerError();

        }

        return ApiController::respondWithError(trans('api.not_exist_phone'));
    }
    public function confirm_forget_password(ConfirmForgetPasswordRequest $request) {
        $check = Merchant::where(function ($q) use($request){
            $q->where('phone',$request->email_or_phone)
                ->orWhere('email',$request->email_or_phone);
        })->whereConfirmCode($request->confirm_code)->first();
        if ($check){
            $check->update([
                'confirm_code'=>null,
            ]);
            return response()->json(['success'=> true,'status' =>  http_response_code() , 'data'=>null , 'message'=>null])->setStatusCode(200);;
        }
        return  ApiController::respondWithError(trans('messages.error_code'));
    }
    public function resetPassword(ResetPasswordRequest $request) {
        $check = Merchant::where(function ($q) use($request){
            $q->where('phone',$request->email_or_phone)
                ->orWhere('email',$request->email_or_phone);
        })->first();
        if($check) {
            $updated = $check->update(['password' => $request->password]);

            return $updated
                ? ApiController::respondWithSuccessMessage(trans('api.Password_changed_successfully'))
                : ApiController::respondWithServerError();
        }
        return ApiController::respondWithError(trans('api.not_exist_phone'));
    }
    public function logout(LogoutRequest $request)
    {
        $exists =UserDevice::where('userable_id',auth()->guard('api_merchant')->user()->id)
            ->where('userable_type',get_class(auth()->guard('api_merchant')->user()))
            ->where('device_identifier',$request->device_identifier)
            ->where('firebase_token',$request->firebase_token)->delete();

        UserToken::where('userable_id',auth()->guard('api_merchant')->user()->id)
            ->where('userable_type',get_class(auth()->guard('api_merchant')->user()))
            ->delete();
        JWTAuth::invalidate(JWTAuth::getToken());

        return  response()->json(['success'=> true,'status' =>  http_response_code(),'message' => null ,'data'=>null ])->setStatusCode(200);


    }

}
