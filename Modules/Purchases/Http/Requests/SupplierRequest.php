<?php

namespace Modules\Purchases\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if( $this->method() == 'PATCH' ) {

            return [
                'name'              => 'required|max:191',
                'email'             => 'required|email|max:191|unique:suppliers,email,'. $this->supplier->id,
                'phone'             => 'required|numeric|unique:suppliers,phone,'. $this->supplier->id,
                'mobile'             => 'required|numeric|unique:suppliers,mobile,'. $this->supplier->id,
                'tax_number'             => 'nullable|numeric|unique:suppliers,tax_number,'. $this->supplier->id,
//                'roles'             => 'nullable',
                'type'             => 'required',
                'commercial_number'             => 'required',
                'address'             => 'required',
                'city_id'             => 'required',
                'country_id'             => 'required',
            ];
        }


        return [
            'name'              => 'required|max:191',
            'email'             => 'required|email|max:191|unique:suppliers',
            'phone'             => 'required|unique:suppliers|numeric',
            'mobile'             => 'required|unique:suppliers|numeric',
            'tax_number'             => 'required|unique:suppliers|numeric',
//            'roles'             => 'required',
            'type'             => 'required',
            'address'             => 'required',
            'city_id'             => 'required',
            'country_id'             => 'required',
            'commercial_number'             => 'required',
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
