<?php

namespace App\Http\Requests\Api\Merchant;

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
            'brand_name' =>'required|max:225',
            'email' =>'required|max:191|email|string|unique:merchants',
            'phone' =>['required', 'regex:/(05)[0-9]{8}/','size:10','unique:merchants'],
            'tax_number' =>'required|unique:merchants',
            'commercial_number' =>'required',
            'commercial_photo' =>'required|mimes:jpg,svg,gif,jpeg,png,tiff',
            'password'                 => ['required','min:8','regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[A-Za-z\d@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
            'firebase_token'          => 'required',
            'device_identifier'           => 'required',
        ];
    }
}
