<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Merchant\AllTransactionsResource;
use App\Http\Resources\Api\Merchant\TransactionsResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    //
    public $user;
    public function __construct()
    {
        $this->user = auth()->guard('api_merchant')->user();
    }
    public function transactions(){
         $data = new TransactionsResource($this->user);
         return ApiController::respondWithSuccess($data);
    }
    public function all_transactions(Request $request){
         $transaction = $this->user->userable()
             ->whereIn('paid_order','paid')
             ->where('confirm', 1)
             ->orderBy('id', 'desc');
        if ($request->type == "week"){
            $transaction = $transaction->whereBetween('created_at',
                [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
            );
        }
        if ($request->type == "month"){
            $transaction = $transaction->whereMonth(
                'created_at', '=', Carbon::now()->month
            );

        }
        if ($request->type == "year"){
            $transaction = $transaction->whereYear('created_at', '=', Carbon::now()->year);
        }
        if ($request->type == "exact_time"){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);
            $transaction = $transaction->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }
        $transaction= $transaction->paginate(10);
        AllTransactionsResource::collection($transaction);
         return ApiController::respondWithSuccess($transaction);
    }
}
