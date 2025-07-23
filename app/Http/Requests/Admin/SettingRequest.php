<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'terms'             => 'required|array',
            "terms.*"           => "required|string",
            'bank_name'             => 'required|array',
            "bank_name.*"           => "required|string",
            'bank_address'             => 'required|array',
            "bank_address.*"           => "required|string",
            'name'             => 'required|array',
            "name.*"           => "required|string",
            'email'           => 'required|email',
            'phone'           => 'required',
            'account_number'           => 'required',
            'bank_code'           => 'required',
            'transaction_count'           => 'required|numeric',
            'transaction_days'           => 'required|numeric',
            'transaction_lowest_count'           => 'required|numeric',
            'transaction_lowest_day'           => 'required|numeric',
            'geidea_percentage'           => 'required|numeric',



        ];
    }
}
