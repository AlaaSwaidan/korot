<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Merchant\ChangePasswordRequest;
use App\Http\Requests\Api\Merchant\EditProfileRequest;
use App\Http\Resources\Api\Merchant\GeideaInfoResource;
use App\Http\Resources\Api\Merchant\ProfileResource;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //
    public $user;
    public function __construct()
    {
        $this->user = auth()->guard('api_merchant')->user();
    }
    public function profile(){
        $user = new ProfileResource($this->user);
        return ApiController::respondWithSuccess($user);
    }
    public function geidea_info(){
        $user = new GeideaInfoResource($this->user);
        return ApiController::respondWithSuccess($user);
    }
    public function edit_profile(EditProfileRequest $request){
        $token = \request()->header('Authorization');
        $api_token=explode("Bearer ", $token);

        if ($request->name !== $this->user->name) {
            return ApiController::respondWithError(trans('api.contact_with_admin_to_change_name'));
        }
        $this->user->update([
//            'name'            => $request->name !== null ? $request->name : $this->user->name,
            'email'            => $request->email !== null ? $request->email : $this->user->email,
            'brand_name'            =>  $request->brand_name !== null ? $request->brand_name : $this->user->brand_name ,
            'image'            =>  $request->image !== null ?  UploadImageEdit($request->file('image'), 'merchant', '/uploads/merchants',$this->user->image) : $this->user->image,

        ]);
        if ($request->deleted_image == 1){
            $this->user->update(['image'=>null]);
            @unlink(public_path('/uploads/merchants/'.$request->image));
        }
        $user = Merchant::find($this->user->id);
        $data = new ProfileResource( $user, $api_token[1]);
        return $user
            ? ApiController::respondWithSuccess($data)
            : ApiController::respondWithServerError();
    }
    public function change_password(ChangePasswordRequest $request){

        if(  Hash::check($request->old_password, $this->user->password)){

            $this->user->update([
                'password'          => $request->password,
            ]);


            return ApiController::respondWithSuccessMessage(trans('api.Password_changed_successfully'));
        }

        return ApiController::respondWithError(trans('api.wrong_old_password'));

    }
}
