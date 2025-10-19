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
//    public function external_service(ExternelServiceRequest $request){
//        $orders = Order::where('parent_id','!=',null)->where('paid_order',"paid");
//        if ($request->from_date && $request->to_date == null){
//            $orders = $orders->whereDate('created_at', '=', $request->from_date);
//        }if ($request->from_date != null && $request->to_date != null){
//            $orders = $orders->whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]);
//        }if($request->merchant_id){
//            $orders = $orders->where('merchant_id',$request->merchant_id);
//        }
//        if ($request->serial_number){
//            $check = Order::where('serial_number', '=', $request->serial_number)->first();
//            $id = $check ? $check->id : 0;
//            $orders = $orders->where('id','>', $id);
//        }
//
//        // Group by merchant_id and package_id, calculate total quantity and total price
//        $orders = $orders
//            ->select(
//                'merchant_id',
//                'package_id',
//                'company_name',
//                'name',
//                DB::raw('SUM(count) as total_quantity'),
//                DB::raw('SUM(merchant_price) as total_price')
//            )
//            ->groupBy('merchant_id', 'package_id','company_name','name')
//            ->orderBy('merchant_id');
//
//        $orders = $orders->get();
////dd($orders);
//         $data = ExternalServiceResource::collection($orders);
//        return ApiController::respondWithSuccess($data);
//    }



    public function external_service(ExternelServiceRequest $request)
    {
        $perPage = (int) $request->get('per_page', 5);
        $page = (int) $request->get('page', 1);
        $offset = ($page - 1) * $perPage;

        // 1️⃣ Base query with filters
        $baseQuery = Order::with(['merchant', 'package.category'])
            ->whereNotNull('parent_id')
            ->where('paid_order', 'paid')
            ->when($request->from_date && !$request->to_date, fn($q) =>
            $q->whereDate('created_at', $request->from_date))
            ->when($request->from_date && $request->to_date, fn($q) =>
            $q->whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]))
            ->when($request->merchant_id, fn($q) =>
            $q->where('merchant_id', $request->merchant_id))
            ->when($request->serial_number, function ($q) use ($request) {
                $check = Order::where('serial_number', $request->serial_number)->first();
                $id = $check ? $check->id : 0;
                $q->where('id', '>', $id);
            });

        // 2️⃣ Fetch just one page (LIMIT + OFFSET) - no grouping yet
        $rows = $baseQuery
            ->orderBy('id')
            ->offset($offset)
            ->limit($perPage)
            ->get([
                'id',
                'merchant_id',
                'package_id',
                'company_name',
                'name',
                'count',
                'merchant_price',
            ]);

        // 3️⃣ Group the *current page* in memory
        $grouped = $rows->groupBy(fn($r) => "{$r->merchant_id}-{$r->package_id}");

        $results = $grouped->map(function ($items) {
            $first = $items->first();

            // Create a "fake" object that looks like Order for the Resource
            $fakeOrder = new Order();
            $fakeOrder->merchant = $first->merchant;
            $fakeOrder->package = $first->package;
            $fakeOrder->company_name = $first->company_name;
            $fakeOrder->name = $first->name;
            $fakeOrder->package_id = $first->package_id;
            $fakeOrder->merchant_id = $first->merchant_id;
            $fakeOrder->total_quantity = $items->sum('count');
            $fakeOrder->total_price = $items->sum('merchant_price');

            return $fakeOrder;
        })->values();

        // 4️⃣ Return paginated response (per-page only)
        return ApiController::respondWithSuccess([
            'Page' => $page,
            'TotalPage' => $perPage,
            'count_items' => $results->count(),
            'data' => ExternalServiceResource::collection($results),
        ]);
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
