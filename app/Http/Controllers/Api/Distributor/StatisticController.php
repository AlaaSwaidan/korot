<?php

namespace App\Http\Controllers\Api\Distributor;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Merchant\MerchantReportsResource;
use App\Http\Resources\Api\Merchant\StatisticsResource;
use App\Models\Merchant;
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
        $this->user = auth()->guard('api_distributor')->user();
    }
    public function statistics(Request $request){
        $transactions =Transfer::where('confirm',1)->where('providerable_type','App\Models\Distributor')
            ->where('providerable_id',$this->user->id);
        $collections = clone $transactions;
        $merchants = Merchant::where('added_by_type','distributor')->where('added_by',$this->user->id);


        if ($request->from_date && $request->to_date){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);
            $transactions = $transactions->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])->where('type','transfer');
            $merchants = $merchants->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
            $diff = $startDate->diff($endDate);
            if ($diff->m > 1){
                $get_data = clone $transactions;

                $transactions = $transactions->where('type',"transfer")
                    ->selectRaw('MONTHNAME(created_at) as day_of_week, SUM(amount) as total')
                    ->groupBy('day_of_week')->get();
                $all = StatisticsResource::collection($transactions);
                $data=[
                    'transfers'=>(string)round($get_data->where('type','transfer')->sum('amount'),2),
                    'collections'=>(string)round($collections->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])->where('type','collection')->sum('amount'),2),
                    'profits'=>(string)round($this->user->profits,2),
                    'merchants_number'=>$merchants->count(),
                    'statistics'=>$all
                ];
                return ApiController::respondWithSuccess($data);
            }else{
                $get_data = clone $transactions;

                $transactions = $transactions->where('type',"transfer")
                    ->selectRaw('DAYNAME(created_at) as day_of_week, SUM(amount) as total')
                    ->groupBy('day_of_week')->get();
                $all = StatisticsResource::collection($transactions);
                $data=[
                    'transfers'=>(string)round($get_data->where('type','transfer')->sum('amount'),2),
                    'collections'=>(string)round($collections->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])->where('type','collection')->sum('amount'),2),
                    'profits'=>(string)round($this->user->profits,2),
                    'merchants_number'=>$merchants->count(),
                    'statistics'=>$all
                ];
                return ApiController::respondWithSuccess($data);
            }
        }
        if ($request->type == "month"){
            $transactions = $transactions->whereMonth(
                'created_at', '=', Carbon::now()->month
            )->where('type','transfer');
            $collections = $collections->whereMonth(
                'created_at', '=', Carbon::now()->month
            )->where('type','collection');

            $merchants = $merchants->whereMonth(
                'created_at', '=', Carbon::now()->month
            );

        }
        if ($request->type == "year"){
            $transactions = $transactions->whereYear('created_at', '=', Carbon::now()->year)->where('type','transfer');
            $merchants = $merchants->whereYear('created_at', '=', Carbon::now()->year);

            $get_data = clone $transactions;

            $transactions = $transactions->where('type',"transfer")
                ->selectRaw('MONTHNAME(created_at) as day_of_week, SUM(amount) as total')
                ->groupBy('day_of_week')->get();
            $all = StatisticsResource::collection($transactions);
            $data=[
                'transfers'=>(string)round($get_data->where('type','transfer')->sum('amount'),2),
                'collections'=>(string)round($collections->whereYear('created_at', '=', Carbon::now()->year)->where('type','collection')->sum('amount'),2),
                'profits'=>(string)round($this->user->profits,2),
                'merchants_number'=>$merchants->count(),
                'statistics'=>$all
            ];
            return ApiController::respondWithSuccess($data);

        }
        if ($request->type == "all"){
            $transactions = $transactions;
            $get_data = clone $transactions;

            $transactions = $transactions->where('type',"transfer")
                ->selectRaw('MONTHNAME(created_at) as day_of_week, SUM(amount) as total')
                ->groupBy('day_of_week')->get();
            $all = StatisticsResource::collection($transactions);
            $data=[
                'transfers'=>(string)round($get_data->where('type','transfer')->sum('amount'),2),
                'collections'=>(string)round($collections->where('type','collection')->sum('amount'),2),
                'profits'=>(string)round($this->user->profits,2),
                'merchants_number'=>$merchants->count(),
                'statistics'=>$all
            ];
            return ApiController::respondWithSuccess($data);
        }
        if ($request->type == "day"){
            $transactions =   $transactions->whereDay('created_at','=',Carbon::now()->day)->where('type','transfer');
            $collections =   $collections->whereDay('created_at','=',Carbon::now()->day)->where('type','collection');
            $merchants =   $merchants->whereDay('created_at','=',Carbon::now()->day);
        }
        if ($request->type == "2_day"){
            $transactions = $transactions->whereBetween('created_at',
                [Carbon::now(), Carbon::now()->subDays(1)]
            )->where('type','transfer');
            $collections = $collections->whereBetween('created_at',
                [Carbon::now(), Carbon::now()->subDays(1)]
            )->where('type','collection');
            $merchants = $merchants->whereBetween('created_at',
                [Carbon::now(), Carbon::now()->subDays(1)]
            );
        }
        $get_data = clone $transactions;

        $transactions = $transactions->where('type',"transfer")
            ->selectRaw('DAYNAME(created_at) as day_of_week, SUM(amount) as total')
            ->groupBy('day_of_week')->get();
        $all = StatisticsResource::collection($transactions);
        $data=[
            'transfers'=>(string)round($get_data->where('type','transfer')->sum('amount'),2),
            'collections'=>(string)round($collections->sum('amount'),2),
            'profits'=>(string)round($this->user->profits,2),
            'merchants_number'=>$merchants->count(),
            'statistics'=>$all
        ];
        return ApiController::respondWithSuccess($data);

    }
}
