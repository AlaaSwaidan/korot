<?php

namespace App\Http\Requests\Api\Merchant;

use App\Http\Requests\REQUEST_API_PARENT;

class ConfirmPaymentRequest extends REQUEST_API_PARENT
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'order_id' =>'required|exists:orders,id',
            'status' =>'required|in:paid,not_paid',
//            'count' =>'required|numeric',
//            'payment_method' =>'required|in:wallet,online',
            'transaction_id' =>'required_if:status,paid',
        ];
    }
}
