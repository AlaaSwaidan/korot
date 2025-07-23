<?php

namespace App\Http\Requests\Api\Merchant;

use App\Http\Requests\REQUEST_API_PARENT;

class ChangeStatusCardRequest extends REQUEST_API_PARENT
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'print_status' =>'required|in:1,0',
            'card_id' =>'required|exists:orders,id',
        ];
    }
}
