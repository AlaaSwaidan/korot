<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use App\Services\Like4AppService;
use Illuminate\Http\Request;
class ToPupLikeCardController extends Controller
{

    public function products(Request $request, Like4AppService $like4App)
    {
        $validated = $request->validate([
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
            'skuCode'        => 'required',
            'receiveAmount'        => 'required|numeric',
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
}
