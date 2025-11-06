<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;


class ZainService
{
    protected  $endpoint = 'https://ers.zain.epayworldwide.com/up-interface';
    protected  $username = 'UPLive_ON000049';
    protected  $password = '9d5c6baf08eb9510';
    protected  $terminalId = 'ON000049';

    public function generateTxId(): string
    {
        return 'TXID_' . now()->format('YmdHis') . rand(100, 999);
    }

    public function buildPinPrintingXml(string $productId, int $amount, string $cashier, string $phone = null): string
    {
        $txid = $this->generateTxId();
        $datetime = now()->format('Y-m-d H:i:s');

        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<REQUEST TYPE="PINPRINTING">
    <USERNAME>{$this->username}</USERNAME>
    <PASSWORD>{$this->password}</PASSWORD>
    <TERMINALID>{$this->terminalId}</TERMINALID>
    <LOCALDATETIME>{$datetime}</LOCALDATETIME>
    <TXID>{$txid}</TXID>
    <CASHIER>{$cashier}</CASHIER>
    <AMOUNT>{$amount}</AMOUNT>
    <PRODUCTID>{$productId}</PRODUCTID>
    <RECEIPT>
        <CHARSPERLINE>40</CHARSPERLINE>
    </RECEIPT>
</REQUEST>
XML;
    }

    public function sendRequest(string $xml): string
    {
        $response = Http::withoutVerifying()
            ->withHeaders(['Content-Type' => 'application/xml'])
            ->withBody($xml, 'application/xml')
            ->post($this->endpoint);

        \Log::info('Zain Request XML:', [$xml]);
        \Log::info('Zain Response:', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return $response->body();
    }
}


