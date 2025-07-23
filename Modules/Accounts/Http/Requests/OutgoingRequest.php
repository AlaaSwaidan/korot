<?php

namespace Modules\Accounts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutgoingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_name'              => 'required|string|max:255',
            'bank_id'             => 'required',
            'payment_method'             => 'required',
            'amount'             => 'required|numeric',
            'date'             => 'required',
            'tax_number'             => 'required',
            'tax'             => 'required',
            'quantity'             => 'required|numeric',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
