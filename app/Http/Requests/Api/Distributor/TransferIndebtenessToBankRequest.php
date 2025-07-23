<?php

namespace App\Http\Requests\Api\Distributor;

use App\Http\Requests\REQUEST_API_PARENT;

class TransferIndebtenessToBankRequest extends REQUEST_API_PARENT
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'amount' =>'required|numeric',
            'photo' =>'required|mimes:jpg,svg,gif,jpeg,png,tiff',

        ];
    }
}
