<?php

namespace App\Http\Controllers\Api\SelfService;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Merchant\CategoryResource;
use App\Http\Resources\Api\Merchant\CompanyResource;
use App\Http\Resources\Api\SelfService\PackageResource;
use App\Models\Package;
use App\Models\Store;
use Illuminate\Http\Request;

class SelfServiceController extends Controller
{
    //
    public function companies(){
        $stores =  Store::OrderByAdmin()->Main()->paginate(20);
        CompanyResource::collection($stores);
        return ApiController::respondWithSuccess($stores);
    }
    public function packages($id,Request $request){
        $stores = Store::find($id);
        if (!$stores)
            return ApiController::respondWithServerError();
        $ids = $stores->categories()->pluck('id')->toArray();

        $data = Package::whereIn('store_id',$ids)->where('status',1)->OrderByAdmin()
            ->where(function ($q){
                $q->whereHas('cards',function ($q1){
                    $q1->where('sold',0);
                });
                $q->orWhere(function ($q3){
                    $q3->Where('gencode_like_card_status',1)->where('gencode_like_card','!=',null);
                });
                $q->orWhere(function ($q3){
                    $q3->Where('gencode_status',1)->where('gencode','!=',null);
                });

            });
        if ($request->name){
            $data->where(function ($q) use($request){
                $q->where('name->ar', 'like', $request->name . '%')
                    ->orWhere('name->ar', 'like', '% ' . $request->name . '%');
                $q->orWhere('name->en', 'like', $request->name . '%')
                    ->orWhere('name->en', 'like', '% ' . $request->name . '%');
            });
        }
        $data = $data->paginate(20);

        PackageResource::collection($data);
        return ApiController::respondWithSuccess($data);
    }
}
