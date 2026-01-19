<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class Like4AppService
{
    protected  $baseUrl;
    protected  $token;

    public function __construct()
    {
        $this->baseUrl = config('services.like4app.base_url');
    }


    /**
     * Get online topup products
     */
    public function getTopupProducts(array $data): array
    {

        $time= \Carbon\Carbon::now()->timestamp;

        $response = Http::asMultipart()
            ->timeout(30)
            ->post('https://taxes.like4app.com/online/topup/products', [
                'deviceId'     => 'b42bdde70294758891a6590127ec802d37e9e1ee0473c45ee86bd14a1db35cda',
                'email'        => '3lialmuslem@gmail.com',
                'password'     => '18c5fd46f0d3ba3929b88feb9e1c4ebe8cd66a5db9a5dd3363f991c727530e5917b96f86a92c4742e9ce77c8a6cf59ec',
                'securityCode' => 'e8f8aca5140c40104f2ccdaf8909953d8f5184e66a43a6d04765fded11afe8e6',
                'langId'       => 1,
                'phone'        => $data['phone'],
                'time'         => $time,
            ]);

        dd($response);
        if ($response->failed()) {
            throw new RequestException($response);
        }

        return $response->json();
    }
}
