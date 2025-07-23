<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ExternelServiceRequest;
use App\Http\Resources\Api\ExternalMerchantServiceResource;
use App\Http\Resources\Api\ExternalServiceResource;
use App\Models\Card;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ExternalServiceController extends Controller
{
    //
    public function external_service(ExternelServiceRequest $request){
        $orders = Order::where('parent_id','!=',null)->where('paid_order',"paid");
        if ($request->from_date && $request->to_date == null){
            $orders = $orders->whereDate('created_at', '=', $request->from_date);
        }if ($request->from_date != null && $request->to_date != null){
            $orders = $orders->whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]);
        }if($request->merchant_id){
            $orders = $orders->where('merchant_id',$request->merchant_id);
        }
        if ($request->serial_number){
            $check = Order::where('serial_number', '=', $request->serial_number)->first();
            $id = $check ? $check->id : 0;
            $orders = $orders->where('id','>', $id);
        }

        // Group by merchant_id and package_id, calculate total quantity and total price
        $orders = $orders
            ->select(
                'merchant_id',
                'package_id',
                'company_name',
                'name',
                DB::raw('SUM(count) as total_quantity'),
                DB::raw('SUM(merchant_price) as total_price')
            )
            ->groupBy('merchant_id', 'package_id','company_name','name')
            ->orderBy('merchant_id');

        $orders = $orders->get();
//dd($orders);
         $data = ExternalServiceResource::collection($orders);
        return ApiController::respondWithSuccess($data);
    }
    public function external_merchant_service(Request $request){

        $orders = Order::where('parent_id','!=',null)->where('paid_order',"paid");
        if ($request->from_date && $request->to_date == null){
            $orders = $orders->whereDate('created_at', '=', $request->from_date);
        }if ($request->from_date != null && $request->to_date != null){
            $orders = $orders->whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]);
        }if($request->merchant_id){
            $orders = $orders->where('merchant_id',$request->merchant_id);
        }
        if ($request->serial_number){
            $check = Order::where('serial_number', '=', $request->serial_number)->first();
            $id = $check ? $check->id : 0;
            $orders = $orders->where('id','>', $id);
        }
// Select distinct merchants and paginate
        $merchants = $orders->select('merchant_id')
            ->distinct()
            ->groupBy('merchant_id');
        $orders = $orders->paginate(50);
        ExternalMerchantServiceResource::collection($orders);
        return ApiController::respondWithSuccess($orders);
    }
}
