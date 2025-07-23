<?php

namespace App\Http\Requests\Api\Merchant;

use App\Http\Requests\REQUEST_API_PARENT;

class ChangePasswordRequest extends REQUEST_API_PARENT
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'old_password'           => 'required',
            'password'                 => ['required','min:8','regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[A-Za-z\d@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
        ];
    }
}
