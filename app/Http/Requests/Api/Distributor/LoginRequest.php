<?php

namespace App\Http\Requests\Api\Distributor;

use App\Http\Requests\REQUEST_API_PARENT;

class LoginRequest extends REQUEST_API_PARENT
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email_or_phone' =>'required',
            'password'                 => 'required|min:6',
            'firebase_token'          => 'required',
            'device_identifier'           => 'required',
        ];
    }
}
