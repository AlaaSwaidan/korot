<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TwelveApiService
{
    protected  $baseUrl;
    protected  $apiKey;
    protected  $apiSecret;

    public function __construct()
    {
        $this->baseUrl = config('services.twelve.base_url');
        $this->apiKey = config('services.twelve.key');
        $this->apiSecret = config('services.twelve.secret');
    }

    protected function client()
    {
        return Http::withHeaders([
            'x-api-key' => $this->apiKey,
            'x-api-secret' => $this->apiSecret,
        ]);
    }

    public function categories()
    {
        return $this->client()->get("{$this->baseUrl}/categories")->json();
    }

    public function products($categoryId = null)
    {
        return $this->client()->get("{$this->baseUrl}/products", [
            'category-id' => $categoryId,
        ])->json();
    }

    public function productDetails(string $productId)
    {
        return $this->client()->get("{$this->baseUrl}/products/{$productId}")->json();
    }

    public function balance()
    {
        return $this->client()->get("{$this->baseUrl}/balance")->json();
    }

    public function orders()
    {
        return $this->client()->get("{$this->baseUrl}/orders")->json();
    }

    public function orderDetails(string $orderId)
    {
        return $this->client()->get("{$this->baseUrl}/orders/{$orderId}")->json();
    }

    public function purchaseVoucher(string $packageId, string $resellerRefNumber)
    {
        $payload = [
            'packageId' => $packageId,
            'resellerRefNumber' => $resellerRefNumber,
        ];

        $response = $this->client()->post("{$this->baseUrl}/purchase", $payload);

        if ($response->failed()) {
            Log::error('Twelve Voucher Purchase Failed', [
                'payload' => $payload,
                'response' => $response->body(),
            ]);
        }

        return $response->json();
    }
}
