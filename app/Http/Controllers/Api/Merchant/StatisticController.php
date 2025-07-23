<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Merchant\MerchantReportsResource;
use App\Http\Resources\Api\Merchant\StatisticsResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Transfers\Entities\Transfer;

class StatisticController extends Controller
{
    //
    public $user;
    public function __construct()
    {
        $this->user = auth()->guard('api_merchant')->user();
    }
    public function statistics(Request $request){
        $transactions  =$this->user->userable()->where('type','sales');

        $orders  =$this->user->orders()->where('parent_id','!=',null)->where('paid_order','paid')->where('status',1);
        if ($request->type == "month"){
            $transactions = $transactions->whereMonth(
                'created_at', '=', Carbon::now()->month
            );
            $orders = $orders->whereMonth(
                'created_at', '=', Carbon::now()->month
            );
            $get_orders = $orders->get()->unique('package_id')->map(function ($all_transactions) {
                $orders =$all_transactions->where('parent_id','!=',null)->where('merchant_id',$this->user->id)->where('paid_order','paid')->where('package_id',$all_transactions->package_id)->whereMonth(
                    'created_at', '=', Carbon::now()->month
                );
//                $merchant_price =$orders->sum('merchant_price');
//                $total =$orders->sum('card_price') - $merchant_price;
//                $all_transactions['total_count']=$orders->count();
//                $all_transactions['merchant_price']=(string)$merchant_price;
//                $all_transactions['cost']=(string)$orders->sum('cost');
//                $all_transactions['profits']=(string)($total);

                /*==*/
                $commission = Transfer::whereOrderId($all_transactions->id)->first();
                $merchant_price =$orders->sum('merchant_price');
                $card_price =$orders->sum('card_price');
                $geidea_commission =$commission ? $commission->geidea_commission : 0;
                $all_cost =$geidea_commission ? $geidea_commission + $merchant_price : $merchant_price;
                $total =$orders->sum('card_price') - $merchant_price  - $geidea_commission;
                $all_transactions['total_count']=$orders->count();
                $all_transactions['merchant_price']=(string)$merchant_price;
                $all_transactions['card_price']=(string)$card_price;
                $all_transactions['profits']=(string)($total);
                $all_transactions['geidea_commission']=(string)($geidea_commission);
                $all_transactions['all_cost']=(string)($all_cost);
                return $all_transactions;
            });
        }
        elseif ($request->type == "year"){
            $transactions = $transactions->whereYear('created_at', '=', Carbon::now()->year);

            $get_data = clone $transactions;

            $transactions = $transactions->where('type',"sales")
                ->selectRaw('MONTHNAME(created_at) as day_of_week, SUM(amount) as total')
                ->groupBy('day_of_week')->get();
            $all = StatisticsResource::collection($transactions);

            $orders = $orders->whereYear('created_at', '=', Carbon::now()->year);

            $get_orders = $orders->get()->unique('package_id')->map(function ($all_transactions) {
                $orders =$all_transactions->where('parent_id','!=',null)->where('merchant_id',$this->user->id)->where('paid_order','paid')->where('package_id',$all_transactions->package_id)->whereYear('created_at', '=', Carbon::now()->year);
//                $merchant_price =$orders->sum('merchant_price');
//                $total =$orders->sum('card_price') - $merchant_price;
//                $all_transactions['total_count']=$orders->count();
//                $all_transactions['merchant_price']=(string)$merchant_price;
//                $all_transactions['cost']=(string)$orders->sum('cost');
//                $all_transactions['profits']=(string)($total);

                $commission = Transfer::whereOrderId($all_transactions->id)->first();
                $merchant_price =$orders->sum('merchant_price');
                $card_price =$orders->sum('card_price');
                $geidea_commission =$commission ? $commission->geidea_commission : 0;
                $all_cost =$geidea_commission ? $geidea_commission + $merchant_price : $merchant_price;
                $total =$orders->sum('card_price') - $merchant_price  - $geidea_commission;
                $all_transactions['total_count']=$orders->count();
                $all_transactions['merchant_price']=(string)$merchant_price;
                $all_transactions['card_price']=(string)$card_price;
                $all_transactions['profits']=(string)($total);
                $all_transactions['geidea_commission']=(string)($geidea_commission);
                $all_transactions['all_cost']=(string)($all_cost);
                return $all_transactions;
            });
            $data=[
                'sales'=>number_format($get_data->sum('amount'),2),
                'balance'=>number_format($get_orders->sum('merchant_price'),2),
                'profits'=>number_format(($get_data->where('type','profits')->sum('amount') + $get_orders->sum('profits')),2),
                'card_numbers'=>$get_orders->sum('total_count'),
                'statistics'=>$all
            ];
            return ApiController::respondWithSuccess($data);
        }
        elseif ($request->type == "all"){
            $transactions = $transactions;
            $orders = $orders;
            $get_data = clone $transactions;
            $profits =$transactions->where('type','sales')->sum('profits');

            $transactions = $transactions->where('type',"sales")
                ->selectRaw('MONTHNAME(created_at) as day_of_week, SUM(amount) as total')
                ->groupBy('day_of_week')->get();
            $all = StatisticsResource::collection($transactions);
            $data=[
                'sales'=>number_format($get_data->sum('amount'),2),
                'balance'=>number_format($orders->sum('merchant_price'),2),
                'profits'=>number_format(($get_data->where('type','profits')->sum('amount') + $profits),2),
                'card_numbers'=>$orders->count(),
                'statistics'=>$all
            ];
            return ApiController::respondWithSuccess($data);
        }
        elseif ($request->type == "day"){
            $transactions =   $transactions->whereDate('created_at','=',Carbon::now()->format('Y-m-d'));
            $orders = $orders->whereDate('created_at','=', Carbon::now()->format('Y-m-d'));
            $get_orders = $orders->get()->unique('package_id')->map(function ($all_transactions) {
                $orders =$all_transactions->where('parent_id','!=',null)->where('merchant_id',$this->user->id)->where('paid_order','paid')
                    ->where('package_id',$all_transactions->package_id)->whereDate('created_at','=',Carbon::now()->format('Y-m-d'));
//                $merchant_price =$orders->sum('merchant_price');
//                $total =$orders->sum('card_price') - $merchant_price;
//                $all_transactions['total_count']=$orders->count();
//                $all_transactions['merchant_price']=(string)$merchant_price;
//                $all_transactions['cost']=(string)$orders->sum('cost');
//                $all_transactions['profits']=(string)($total);
                $commission = Transfer::whereOrderId($all_transactions->id)->first();
                $merchant_price =$orders->sum('merchant_price');
                $card_price =$orders->sum('card_price');
                $geidea_commission =$commission ? $commission->geidea_commission : 0;
                $all_cost =$geidea_commission ? $geidea_commission + $merchant_price : $merchant_price;
                $total =$orders->sum('card_price') - $merchant_price  - $geidea_commission;
                $all_transactions['total_count']=$orders->count();
                $all_transactions['merchant_price']=(string)$merchant_price;
                $all_transactions['card_price']=(string)$card_price;
                $all_transactions['profits']=(string)($total);
                $all_transactions['geidea_commission']=(string)($geidea_commission);
                $all_transactions['all_cost']=(string)($all_cost);
                return $all_transactions;
            });
        }
        elseif ($request->type == "2_day"){
            $transactions = $transactions
                ->whereDate('created_at','=', Carbon::now()->subDays(1)->format('Y-m-d'));
            $orders = $orders->whereDate('created_at','=', Carbon::now()->subDays(1)->format('Y-m-d'));
            $get_orders = $orders->get()->unique('package_id')->map(function ($all_transactions) {
                $orders =$all_transactions->where('parent_id','!=',null)->where('merchant_id',$this->user->id)
                    ->where('paid_order','paid')->where('package_id',$all_transactions->package_id)
                    ->whereDate('created_at','=', Carbon::now()->subDays(1)->format('Y-m-d'));

//                $merchant_price =$orders->sum('merchant_price');
//                $total =$orders->sum('card_price') - $merchant_price;
//                $all_transactions['total_count']=$orders->count();
//                $all_transactions['merchant_price']=(string)$merchant_price;
//                $all_transactions['cost']=(string)$orders->sum('cost');
//                $all_transactions['profits']=(string)($total);
                $commission = Transfer::whereOrderId($all_transactions->id)->first();
                $merchant_price =$orders->sum('merchant_price');
                $card_price =$orders->sum('card_price');
                $geidea_commission =$commission ? $commission->geidea_commission : 0;
                $all_cost =$geidea_commission ? $geidea_commission + $merchant_price : $merchant_price;
                $total =$orders->sum('card_price') - $merchant_price  - $geidea_commission;
                $all_transactions['total_count']=$orders->count();
                $all_transactions['merchant_price']=(string)$merchant_price;
                $all_transactions['card_price']=(string)$card_price;
                $all_transactions['profits']=(string)($total);
                $all_transactions['geidea_commission']=(string)($geidea_commission);
                $all_transactions['all_cost']=(string)($all_cost);
                return $all_transactions;
            });
        }
        elseif ($request->from_date && $request->to_date){
            if ($request->from_time && $request->to_time){
                $startDate = Carbon::parse($request->from_date.' '.$request->from_time);
                $endDate = Carbon::parse($request->to_date.' '.$request->to_time);
                $transactions = $transactions->where('created_at', '>=',$startDate)
                    ->where('created_at', '<=', $endDate);
                $orders = $orders->where('created_at', '>=',$startDate)
                    ->where('created_at', '<=', $endDate);
                $diff = $startDate->diff($endDate);
                $get_orders = $orders->get()->unique('package_id')->map(function ($all_transactions) use ($startDate,$endDate){
                    $orders =$all_transactions->where('parent_id','!=',null)->where('merchant_id',$this->user->id)
                        ->where('paid_order','paid')->where('package_id',$all_transactions->package_id)
                        ->where('created_at', '>=',$startDate)
                        ->where('created_at', '<=', $endDate);
//                    $merchant_price =$orders->sum('merchant_price');
//                    $total =$orders->sum('card_price') - $merchant_price;
//                    $all_transactions['total_count']=$orders->count();
//                    $all_transactions['merchant_price']=(string)$merchant_price;
//                    $all_transactions['cost']=(string)$orders->sum('cost');
//                    $all_transactions['profits']=(string)($total);
                    $commission = Transfer::whereOrderId($all_transactions->id)->first();
                    $merchant_price =$orders->sum('merchant_price');
                    $card_price =$orders->sum('card_price');
                     $geidea_commission =$commission ? $commission->geidea_commission : 0;
                     $all_cost =$geidea_commission ? $geidea_commission + $merchant_price : $merchant_price;
                    $total =$orders->sum('card_price') - $merchant_price  - $geidea_commission;
                    $all_transactions['total_count']=$orders->count();
                    $all_transactions['merchant_price']=(string)$merchant_price;
                    $all_transactions['card_price']=(string)$card_price;
                    $all_transactions['profits']=(string)($total);
                    $all_transactions['geidea_commission']=(string)($geidea_commission);
                    $all_transactions['all_cost']=(string)($all_cost);
                    return $all_transactions;
                });
            }else{
                $startDate = Carbon::parse($request->from_date);
                $endDate = Carbon::parse($request->to_date);
                $transactions = $transactions->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
                $orders = $orders->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
                $diff = $startDate->diff($endDate);
                $get_orders = $orders->get()->unique('package_id')->map(function ($all_transactions) use ($startDate,$endDate){
                    $orders =$all_transactions->where('parent_id','!=',null)->where('merchant_id',$this->user->id)
                        ->where('paid_order','paid')->where('package_id',$all_transactions->package_id)
                        ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
//                    $merchant_price =$orders->sum('merchant_price');
//                    $total =$orders->sum('card_price') - $merchant_price;
//                    $all_transactions['total_count']=$orders->count();
//                    $all_transactions['merchant_price']=(string)$merchant_price;
//                    $all_transactions['cost']=(string)$orders->sum('cost');
//                    $all_transactions['profits']=(string)($total);
                    $commission = Transfer::whereOrderId($all_transactions->id)->first();
                    $merchant_price =$orders->sum('merchant_price');
                    $card_price =$orders->sum('card_price');
                     $geidea_commission =$commission ? $commission->geidea_commission : 0;
                $all_cost =$geidea_commission ? $geidea_commission + $merchant_price : $merchant_price;
                    $total =$orders->sum('card_price') - $merchant_price  - $geidea_commission;
                    $all_transactions['total_count']=$orders->count();
                    $all_transactions['merchant_price']=(string)$merchant_price;
                    $all_transactions['card_price']=(string)$card_price;
                    $all_transactions['profits']=(string)($total);
                    $all_transactions['geidea_commission']=(string)($geidea_commission);
                    $all_transactions['all_cost']=(string)($all_cost);
                    return $all_transactions;
                });
            }



            if ($diff->m > 1){
                $get_data = clone $transactions;

                $transactions = $transactions->where('type',"sales")
                    ->selectRaw('MONTHNAME(created_at) as day_of_week, SUM(amount) as total')
                    ->groupBy('day_of_week')->get();
                $all = StatisticsResource::collection($transactions);

                $data=[
                    'sales'=>number_format($get_data->sum('amount'),2),
                    'balance'=>number_format($get_orders->sum('merchant_price'),2),
                    'profits'=>number_format(($get_data->where('type','profits')->sum('amount') + $get_orders->sum('profits')),2),
                    'card_numbers'=>$get_orders->sum('total_count'),
                    'statistics'=>$all
                ];
                return ApiController::respondWithSuccess($data);
            }
            else{
                $get_data = clone $transactions;

                $transactions = $transactions->where('type',"sales")
                    ->selectRaw('DAYNAME(created_at) as day_of_week, SUM(amount) as total')
                    ->groupBy('day_of_week')->get();
                $all = StatisticsResource::collection($transactions);
                $data=[
                    'sales'=>number_format($get_data->sum('amount'),2),
                    'balance'=>number_format($get_orders->sum('merchant_price'),2),
                    'profits'=>number_format(($get_data->where('type','profits')->sum('amount') + $get_orders->sum('profits')),2),
                    'card_numbers'=>$get_orders->sum('total_count'),
                    'statistics'=>$all
                ];
                return ApiController::respondWithSuccess($data);
            }
        }

        $get_data = clone $transactions;

        $transactions = $transactions->where('type',"sales")
            ->selectRaw('DAYNAME(created_at) as day_of_week, SUM(amount) as total')
            ->groupBy('day_of_week')->get();
        $all = StatisticsResource::collection($transactions);
        $data=[
            'sales'=>number_format($get_data->sum('amount'),2),
            'balance'=>number_format($get_orders->sum('merchant_price'),2),
            'profits'=>number_format(($get_data->where('type','profits')->sum('amount') + $get_orders->sum('profits')),2),
            'card_numbers'=>$get_orders->sum('total_count'),
            'statistics'=>$all
        ];
        return ApiController::respondWithSuccess($data);

    }
    public function merchant_reports(Request $request){
        $transactions  =$this->user->userable()->where('type','sales');
        $orders  =$this->user->orders()->where('parent_id','!=',null)
            ->where('paid_order',"paid")->where('status',1);
        if ($request->from_date && $request->to_date){
            if ($request->from_time && $request->to_time){
                $startDate = Carbon::parse($request->from_date.' '.$request->from_time);
                $endDate = Carbon::parse($request->to_date.' '.$request->to_time);
                $transactions = $transactions->where('created_at', '>=',$startDate)
                    ->where('created_at', '<=', $endDate);
                $orders = $orders->where('created_at', '>=',$startDate)
                    ->where('created_at', '<=', $endDate);

                $get_data = clone $transactions;

                $profits =$transactions->where('type','sales')->sum('profits');
                $get_orders = $orders->get()->unique('package_id')->map(function ($all_transactions) use ($startDate,$endDate){
                    $orders =$all_transactions->where('parent_id','!=',null)->where('merchant_id',$this->user->id)
                        ->where('paid_order',"paid")->where('package_id',$all_transactions->package_id)
                        ->where('created_at', '>=',$startDate)
                        ->where('created_at', '<=', $endDate);
//                    $merchant_price =$orders->sum('merchant_price');
//                    $total =$orders->sum('card_price') - $merchant_price;
//                    $all_transactions['total_count']=$orders->count();
//                    $all_transactions['merchant_price']=(string)$merchant_price;
//                    $all_transactions['cost']=(string)$orders->sum('cost');
//                    $all_transactions['profits']=(string)($total);


                    $commission = Transfer::whereOrderId($all_transactions->id)->first();
                    $merchant_price =$orders->sum('merchant_price');
                    $card_price =$orders->sum('card_price');
                     $geidea_commission =$commission ? $commission->geidea_commission : 0;
                $all_cost =$geidea_commission ? $geidea_commission + $merchant_price : $merchant_price;
                    $total =$orders->sum('card_price') - $merchant_price  - $geidea_commission;
                    $all_transactions['total_count']=$orders->count();
                    $all_transactions['merchant_price']=(string)$merchant_price;
                    $all_transactions['card_price']=(string)$card_price;
                    $all_transactions['profits']=(string)($total);
                    $all_transactions['geidea_commission']=(string)($geidea_commission);
                    $all_transactions['all_cost']=(string)($all_cost);
                    return $all_transactions;
                });
            }else{
                $startDate = Carbon::parse($request->from_date);
                $endDate = Carbon::parse($request->to_date);
                $transactions = $transactions->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
                $orders = $orders->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);

                $get_data = clone $transactions;

                $profits =$transactions->where('type','sales')->sum('profits');
                $get_orders = $orders->get()->unique('package_id')->map(function ($all_transactions) use ($startDate,$endDate){
                    $orders =$all_transactions->where('parent_id','!=',null)->where('merchant_id',$this->user->id)
                        ->where('paid_order',"paid")->where('package_id',$all_transactions->package_id)
                        ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
//                    $merchant_price =$orders->sum('merchant_price');
//                    $total =$orders->sum('card_price') - $merchant_price;
//                    $all_transactions['total_count']=$orders->count();
//                    $all_transactions['merchant_price']=(string)$merchant_price;
//                    $all_transactions['cost']=(string)$orders->sum('cost');
//                    $all_transactions['profits']=(string)($total);
                    $commission = Transfer::whereOrderId($all_transactions->id)->first();
                    $merchant_price =$orders->sum('merchant_price');
                    $card_price =$orders->sum('card_price');
                     $geidea_commission =$commission ? $commission->geidea_commission : 0;
                $all_cost =$geidea_commission ? $geidea_commission + $merchant_price : $merchant_price;
                    $total =$orders->sum('card_price') - $merchant_price  - $geidea_commission;
                    $all_transactions['total_count']=$orders->count();
                    $all_transactions['merchant_price']=(string)$merchant_price;
                    $all_transactions['card_price']=(string)$card_price;
                    $all_transactions['profits']=(string)($total);
                    $all_transactions['geidea_commission']=(string)($geidea_commission);
                    $all_transactions['all_cost']=(string)($all_cost);
                    return $all_transactions;
                });
            }

                $all =  MerchantReportsResource::collection($get_orders);
                $data=[
                    //                    'balance'=>number_format(($get_data->first() ? $get_data->first()->balance_total : 0),2),
                    'merchant_name'=>$this->user->name,
                    'merchant_id'=>$this->user->id,
//                    'merchant_balance'=>(string)$this->user->balance,
                    'merchant_balance'=>number_format($this->user->balance,2),
                    'card_numbers'=>$get_orders->sum('total_count'),
                    'cost'=>number_format($get_orders->sum('merchant_price'),2),
                    'profits'=>number_format(($get_data->where('type','profits')->sum('amount') + $get_orders->sum('profits')),2),
                    'from_date'=>$startDate->format('Y-m-d'),
                    'to_date'=>$endDate->format('Y-m-d'),
                    'reports'=>$all,
                ];
                return ApiController::respondWithSuccess($data);

        }

    }
}
