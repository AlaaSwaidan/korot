<?php

namespace App\Http\Controllers\Api\Distributor;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Distributor\ChangePasswordRequest;
use App\Http\Requests\Api\Distributor\EditProfileRequest;
use App\Http\Resources\Api\Distributor\ProfileResource;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->user = auth()->guard('api_distributor')->user();
    }
    public function profile(){
        $user = new ProfileResource($this->user);
        return ApiController::respondWithSuccess($user);
    }

    public function edit_profile(EditProfileRequest $request){
        $token = \request()->header('Authorization');
        $api_token=explode("Bearer ", $token);
        $this->user->update([
            'name'            => $request->name !== null ? $request->name : $this->user->name,
            'email'            => $request->email !== null ? $request->email : $this->user->email,
            'image'            =>  $request->image !== null ?  UploadImageEdit($request->file('image'), 'distributors', '/uploads/distributors',$this->user->image) : $this->user->image,

        ]);
        if ($request->deleted_image == 1){
            $this->user->update(['image'=>null]);
            @unlink(public_path('/uploads/distributors/'.$request->image));
        }
        $user = Distributor::find($this->user->id);
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
