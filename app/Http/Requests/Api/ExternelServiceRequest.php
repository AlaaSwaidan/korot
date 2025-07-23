<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\REQUEST_API_PARENT;

class ExternelServiceRequest extends REQUEST_API_PARENT
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'merchant_id' =>'required|exists:merchants,id',
        ];
    }
}
