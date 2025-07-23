<?php

namespace App\Http\Requests\Api\Merchant;

use App\Http\Requests\REQUEST_API_PARENT;

class TransferProfitToBankRequest extends REQUEST_API_PARENT
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'amount' =>'required|numeric',
            'bank_name' =>'required',
            'bank_address' =>'required',
            'bank_city' =>'required',
            'bank_country' =>'required',
        ];
    }
}
