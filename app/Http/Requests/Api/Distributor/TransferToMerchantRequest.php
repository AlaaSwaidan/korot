<?php

namespace App\Http\Requests\Api\Distributor;

use App\Http\Requests\REQUEST_API_PARENT;

class TransferToMerchantRequest extends REQUEST_API_PARENT
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount' =>'required|numeric|min:1',
            'merchant_id' =>'required|exists:merchants,id',

        ];
    }
}
