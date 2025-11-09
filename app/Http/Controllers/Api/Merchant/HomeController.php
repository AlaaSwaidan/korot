<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Merchant\CategoryResource;
use App\Http\Resources\Api\Merchant\CompanyResource;
use App\Http\Resources\Api\Merchant\DepartmentResource;
use App\Http\Resources\Api\Merchant\PackageResource;
use App\Models\Department;
use App\Models\Store;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function departments(){
       $stores =  Department::paginate(20);
        DepartmentResource::collection($stores);
        return ApiController::respondWithSuccess($stores);
    }
    public function all_companies($id){
        $department = Department::find($id);
        if(!$department)   return ApiController::respondWithServerError();
//        $stores = Store::OrderByAdmin()
//            ->whereIn('id',$department->stores_id)
//            ->Main()
//            ->paginate(20);

        $stores = Store::select('stores.*')
            ->whereIn('stores.id', $department->stores_id)
            ->leftJoin('merchant_stores', 'stores.id', '=', 'merchant_stores.store_id')
            ->where(function ($query) {
                $query->whereNull('merchant_stores.merchant_id')
                    ->orWhere('merchant_stores.merchant_id', auth()->guard('api_merchant')->user()->id);
            })
            ->orderByAdmin()
            ->main()
            ->distinct()
            ->paginate(20);
        CompanyResource::collection($stores);
        return ApiController::respondWithSuccess($stores);
    }
    public function companies(){
        $stores = Store::select('stores.*')
            ->leftJoin('merchant_stores', 'stores.id', '=', 'merchant_stores.store_id')
            ->where(function ($query)  {
                $query->whereNull('merchant_stores.merchant_id')
                    ->orWhere('merchant_stores.merchant_id', auth()->guard('api_merchant')->user()->id);
            })
            ->orderByAdmin()
            ->main()
            ->distinct()
            ->paginate(20);
        CompanyResource::collection($stores);
        return ApiController::respondWithSuccess($stores);
    }
    public function categories($id){
        $store = Store::find($id);
        if (!$store)
            return ApiController::respondWithServerError();

        $data = $store->categories()->OrderByAdmin()->paginate(20);
        CategoryResource::collection($data);
        return ApiController::respondWithSuccess($data);
    }
    public function packages($id){
        $category = Store::find($id);
        if (!$category)
            return ApiController::respondWithServerError();

        $data = $category->packages()->where('status', 1)
            ->where(function ($q) {
                $q->whereHas('cards', function ($q1) {
                    $q1->where('sold', 0);
                })
                    ->orWhere(function ($q2) {
                        $q2->where('gencode_like_card_status', 1)
                            ->whereNotNull('gencode_like_card');
                    })
                    ->orWhere(function ($q3) {
                        $q3->where('gencode_status', 1)
                            ->whereNotNull('gencode');
                    })
                    ->orWhere(function ($q3) {
                        $q3->where('zain_status', 1)
                            ->whereNotNull('product_id_zain');
                    });
            })
            ->OrderByAdmin()
            ->paginate(20);
//        if ($data->count() > 0){
//            $data = $data->paginate(20);
//        }else{
//            $data =$category->packages()->where('status',1)->OrderByAdmin()
//                ->where('gencode','!=',null)->paginate(20);
//        }
        PackageResource::collection($data);
        return ApiController::respondWithSuccess($data);
    }
}
