<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ZainService;
use Illuminate\Http\Request;


class ZainIntegrationController extends Controller
{
    //
    protected $zain;

    public function __construct(ZainService $zain)
    {
        $this->zain = $zain;
    }

    public function topUp(Request $request)
    {
        $phone = $request->input('phone', '966500000000');
        $productId = $request->input('product_id', '9111119001003'); // 30 SAR
        $amount = $request->input('amount', 3000); // 30 SAR * 100

        $xml = $this->zain->buildTopUpXml($phone, $productId, $amount);
        $response = $this->zain->sendRequest($xml);

        $parsed = simplexml_load_string($response);

        return response()->json([
            'raw_response' => $response,
            'result'       => (string)$parsed->RESULT,
            'result_text'  => (string)$parsed->RESULTTEXT,
            'receipt'      => (array)$parsed->RECEIPT ?? [],
        ]);
    }

}
