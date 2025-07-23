<?php

namespace App\Http\Requests\Api\Merchant;

use App\Http\Requests\REQUEST_API_PARENT;

class ResetPasswordRequest extends REQUEST_API_PARENT
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email_or_phone' =>'required',
            'password'              => 'required|min:6',
        ];
    }
}
