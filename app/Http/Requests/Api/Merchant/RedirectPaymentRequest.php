<?php

namespace App\Http\Requests\Api\Merchant;

use App\Http\Requests\REQUEST_API_PARENT;

class RedirectPaymentRequest extends REQUEST_API_PARENT
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'order_id' =>'required',
//            'count' =>'required|numeric',
            'status' =>'required|in:paid,not_paid',
            'transaction_id' =>'required_if:status,paid',
        ];
    }
}
