<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use App\Models\CountrySetting;
use App\Models\Statistic;
use App\Models\TopupOrder;
use App\Services\Like4AppService;
use Illuminate\Http\Request;
class ToPupLikeCardController extends Controller
{

    public function __construct()
    {
        $this->user = auth()->guard('api_merchant')->user();
    }
    public function products(Request $request, Like4AppService $like4App)
    {
        $validated = $request->validate([
            'country_code'        => 'required|string',
            'phone'        => 'required|string',
        ]);

        try {
            $products = $like4App->getTopupProducts($validated);

            return response()->json([
                'success' => true,
                'data' => $products,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Like4App API error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function check_price(Request $request, Like4AppService $like4App)
    {
        $validated = $request->validate([
            'phone'        => 'required|string',
            'country_code'        => 'required|string',
            'skuCode'        => 'required',
            'amount'        => 'required|numeric',
        ]);

        try {
            $products = $like4App->checkProductPrice($validated);

            return response()->json([
                'success' => true,
                'data' => $products,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Like4App API error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function send(Request $request, Like4AppService $like4App)
    {
        $validated = $request->validate([
            'phone'        => 'required|string',
            'country_code'        => 'required|string',
            'skuCode'        => 'required',
            'sellPrice'        => 'required|numeric',
            'amount'        => 'required|numeric',//receiveAmount
            'price'        => 'required|numeric',
        ]);

        try {
            $products = $like4App->send($validated);

//            if ($products['response'] == 1){
//                $country = CountrySetting::where('code',$validated['country_code'])->first();
//                $merchant_percent = $country ? $country->merchant_percentage : 1;
//                $profit = (float)$request->sellPrice - (float)$request->price;
//                $merchant_profit = $profit * $merchant_percent / 100;
//                $admin_profit = $profit - $merchant_profit;
//
//
//                TopupOrder::create([
//                    'merchant_id'=>$this->user,
//                    'phone'=>$request->phone,
//                    'country_code'=>$request->country_code,
//                    'sku_code'=>$request->skuCode,
//                    'price'=>$request->price,//cost
//                    'sell_price'=>$request->sellPrice,
//                    'receive_amount'=>$request->amount,//receiveAmount for user
//                    'merchant_percentage'=>$merchant_percent,
//                    'merchant_profit'=>$merchant_profit,
//                    'admin_profit'=>$admin_profit
//                ]);
//
//                $this->user->increment('topup_wallet', $merchant_profit);
//
//                $statictics = Statistic::find(1);
//                $statictics->increment('topup_wallet',$admin_profit);
//
//                $statictics->increment('topup_cost',$request->price);
//
//            }
            return response()->json([
                'success' => true,
                'data' => $products,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Like4App API error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
