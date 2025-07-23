<?php

namespace App\Http\Requests\Api\Distributor;

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
            'password'              => 'required|min:6',
        ];
    }
}
