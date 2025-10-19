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


    public function sale(Request $request, ZainService $zain)
    {
        $phone = $request->input('phone', '966500000000');
        $productId = $request->input('product_id', '9111119002014'); // 30 SAR
        $amount = $request->input('amount', 10000); // 30 SAR * 100

        $xml = $zain->buildSaleXml($phone, $productId, $amount);
        $response = $zain->sendRequest($xml);

        if (strpos($response, '<') !== 0) {
            return response()->json([
                'raw_response' => $response,
                'error' => 'Non-XML response from Zain'
            ], 500);
        }

        $parsed = simplexml_load_string($response);
        return response()->json([
            'raw_response' => $response,
            'result' => (string)($parsed->RESULT ?? ''),
            'result_text' => (string)($parsed->RESULTTEXT ?? ''),
            'receipt' => (array)($parsed->RECEIPT ?? []),
        ]);
    }

    public function pinPrinting(Request $request, ZainService $zain)
    {
        $productId = $request->input('product_id', '9111119001003'); // 30 SAR voucher
        $amount = $request->input('amount', 3000); // 30 SAR × 100
        $cashier = $request->input('cashier', 'Ahmed');

        $results = [];

        for ($i = 1; $i <= 5; $i++) {
            $zain = new ZainService();
            $xml = $zain->buildPinPrintingXml($productId, $amount, $cashier);
            $response = $zain->sendRequest($xml);

            if (strpos($response, '<') !== 0) {
                $results[] = [
                    'index' => $i,
                    'error' => 'Invalid XML response',
                    'raw' => $response,
                ];
                continue;
            }

            $parsed = simplexml_load_string($response);

            $results[] = [
                'index' => $i,
                'raw_response' => $response,
                'result' => (string)($parsed->RESULT ?? ''),
                'result_text' => (string)($parsed->RESULTTEXT ?? ''),
                'pin' => (string)($parsed->PINCREDENTIALS->PIN ?? ''),
                'serial' => (string)($parsed->PINCREDENTIALS->SERIAL ?? ''),
                'valid_to' => (string)($parsed->PINCREDENTIALS->VALIDTO ?? ''),
            ];
        }
        foreach ($results as $result) {
            dd($result['pin']);
        }
        dd($results);

        $xml = $zain->buildPinPrintingXml($productId, $amount, $cashier);
        $response = $zain->sendRequest($xml);

        if (strpos($response, '<') !== 0) {
            return response()->json(['error' => 'Invalid XML response', 'raw' => $response], 500);
        }

        $parsed = simplexml_load_string($response);
        return response()->json([
            'raw_response' => $response,
            'result' => (string)($parsed->RESULT ?? ''),
            'result_text' => (string)($parsed->RESULTTEXT ?? ''),
            'pin' => (string)($parsed->PINCREDENTIALS->PIN ?? ''),
            'serial' => (string)($parsed->PINCREDENTIALS->SERIAL ?? ''),
            'valid_to' => (string)($parsed->PINCREDENTIALS->VALIDTO ?? ''),
        ]);
    }
}
