<?php

namespace App\Http\Requests\Api\Distributor;

use App\Http\Requests\REQUEST_API_PARENT;

class RegisterRequest extends REQUEST_API_PARENT
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' =>'required|max:225',
            'email' =>'required|max:191|email|string|unique:distributors',
            'phone' =>['required', 'regex:/(05)[0-9]{8}/','size:10','unique:distributors'],
            'tax_number'             => 'required|unique:distributors|numeric',
            'identity_id'    => 'required|unique:distributors|numeric',
            'password'          => 'required|min:6|max:191',
            'firebase_token'          => 'required',
            'device_identifier'           => 'required',
            "photo"                => "nullable|mimes:jpg,gif,jpeg,png,tiff",
            "identity_photo"                => "required|mimes:jpg,gif,jpeg,png,tiff",

        ];
    }
}
