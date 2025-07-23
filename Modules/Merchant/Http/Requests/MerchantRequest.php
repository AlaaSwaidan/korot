<?php

namespace Modules\Merchant\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchantRequest extends FormRequest
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
                'brand_name'              => 'required|max:191',
                'email'             => 'required|email|max:191|unique:merchants,email,'. $this->merchant->id,
                'phone'             => 'required|numeric|unique:merchants,phone,'. $this->merchant->id,
                'tax_number'             => 'nullable|numeric|unique:merchants,phone,'. $this->merchant->id,
//                'roles'             => 'nullable',
                'status'             => 'nullable',
                'type'             => 'required',
                'commercial_number'             => 'required',
                'location'             => 'required',
                'machine_number'             => 'required',
                'geidea_percentage'             => 'nullable|numeric',
                "photo"                => "nullable|mimes:jpg,gif,jpeg,png,tiff",
            ];
        }


        return [
            'name'              => 'required|max:191',
            'brand_name'              => 'required|max:191',
            'email'             => 'required|email|max:191|unique:merchants',
            'phone'             => 'required|unique:merchants|numeric',
            'tax_number'             => 'required|unique:merchants|numeric',
//            'roles'             => 'required',
            'status'             => 'nullable',
            'type'             => 'required',
            'location'             => 'required',
            'machine_number'             => 'required',
            'commercial_number'             => 'required',
            'password'          => 'required|min:3|max:191',
            'password_confirm'  => 'required|same:password',
            'geidea_percentage'             => 'nullable|numeric',
            "photo"                => "nullable|mimes:jpg,gif,jpeg,png,tiff",
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
