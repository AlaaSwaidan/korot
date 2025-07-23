<?php

namespace App\Http\Requests\Api\Merchant;

use App\Http\Requests\REQUEST_API_PARENT;

class EditProfileRequest extends REQUEST_API_PARENT
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'deleted_image' =>'required|in:0,1',
            'name' =>'nullable|max:225',
            'brand_name' =>'nullable|max:225',
            'email' =>'nullable|max:191|email|string|unique:merchants,email,'.$this->user('api_merchant')->id,
            'image' =>'nullable|mimes:jpg,svg,gif,jpeg,png,tiff',

        ];
    }
}
