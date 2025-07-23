<?php

namespace App\Http\Requests\Api\Merchant;

use App\Http\Requests\REQUEST_API_PARENT;

class AddOrderRequest extends REQUEST_API_PARENT
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'package_id' =>'required|exists:packages,id',
            'count' =>'required|numeric',
            'payment_method' =>'required|in:wallet,online',
        ];
    }
}
