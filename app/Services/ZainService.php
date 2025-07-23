<?php

// app/Services/ZainService.php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZainService
{
    protected $endpoint = 'https://webservice-test.zain.epayworldwide.com/up-interface';

    protected $username = 'UPLive_ON000041';
    protected $password = '4016a35288d6808a';
    protected $terminalId = 'ON000041';

    public function generateTxId()
    {
        return 'TXID_' . now()->format('YmdHis') . rand(1000, 9999);
    }

    public function buildTopUpXml(string $phone, string $productId, int $amount): string
    {
        $txid = $this->generateTxId();
        $datetime = now()->format('Y-m-d H:i:s');

        return <<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<REQUEST type="SALE">
    <USERNAME>{$this->username}</USERNAME>
    <PASSWORD>{$this->password}</PASSWORD>
    <TERMINALID>{$this->terminalId}</TERMINALID>
    <LOCALDATETIME>{$datetime}</LOCALDATETIME>
    <TXID>{$txid}</TXID>
    <PHONE>{$phone}</PHONE>
    <PRODUCTID>{$productId}</PRODUCTID>
    <AMOUNT>{$amount}</AMOUNT>
    <CURRENCY>682</CURRENCY>
    <RECEIPT>
        <CHARSPERLINE>40</CHARSPERLINE>
    </RECEIPT>
</REQUEST>
XML;
    }

    public function sendRequest(string $xml): string
    {
        $response = Http::withHeaders([
            'Content-Type' => 'text/xml',
        ])->withBody($xml, 'text/xml')->post($this->endpoint);

        return $response->body();
    }
}
