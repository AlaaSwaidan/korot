<?php

namespace App\Http\Controllers\Api\Distributor;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    public $user;
    public function __construct()
    {
        $this->user = auth()->guard('api_distributor')->user();
    }
    public function listNotifications(Request $request) {

        $data = Notification::Where('userable_id', $this->user->id)->where('userable_type',get_class($this->user))->orderBy('id','desc')->paginate(10);
        Notification::Where('userable_id', $this->user->id)->where('userable_type',get_class($this->user))->update(['seen'=>1]);

        NotificationResource::collection($data);

        return ApiController::respondWithSuccess($data);
    }

    public function delete_Notifications( $id , Request $request) {

        $data = Notification::Where('id', $id)->Where('userable_id', $this->user->id)
            ->where('userable_type',get_class($this->user))->delete();

        return $data
            ? response()->json(['success'=> true,'status' =>  http_response_code() , 'data'=>null , 'message'=>null])->setStatusCode(200)
            : ApiController::respondWithServerError();
    }
    public function delete_all_Notifications( Request $request) {

        $data = Notification::Where('userable_id', $this->user->id)->where('userable_type',get_class($this->user))->delete();
        return $data
            ? response()->json(['success'=> true,'status' =>  http_response_code() , 'data'=>null , 'message'=>null])->setStatusCode(200)
            : ApiController::respondWithServerError();
    }
}
