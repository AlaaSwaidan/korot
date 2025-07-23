<?php

namespace App\Http\Requests\Api\Distributor;

use App\Http\Requests\REQUEST_API_PARENT;

class ConfirmRegisterRequest extends REQUEST_API_PARENT
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' =>'required|exists:distributors',
            'confirm_code' =>'required',

        ];
    }
}
