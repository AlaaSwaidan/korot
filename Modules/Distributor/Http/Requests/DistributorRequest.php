<?php

namespace Modules\Distributor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DistributorRequest extends FormRequest
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
                'email'             => 'required|email|max:191|unique:distributors,email,'. $this->distributor->id,
                'phone'             => 'required|numeric|unique:distributors,phone,'. $this->distributor->id,
                'identity_id'             => 'required|numeric|unique:distributors,phone,'. $this->distributor->id,
                'tax_number'             => 'nullable|numeric|unique:distributors,phone,'. $this->distributor->id,
//                'roles'             => 'nullable',
                'status'             => 'nullable',
                "photo"                => "nullable|mimes:jpg,gif,jpeg,png,tiff",
                "identity_photo"                => "nullable|mimes:jpg,gif,jpeg,png,tiff",
            ];
        }


        return [
            'name'              => 'required|max:191',
            'email'             => 'required|email|max:191|unique:distributors',
            'phone'             => 'required|unique:distributors|numeric',
            'identity_id'             => 'required|unique:distributors|numeric',
            'tax_number'             => 'required|unique:distributors|numeric',
//            'roles'             => 'required',
            'status'             => 'nullable',
            'password'          => 'required|min:3|max:191',
            'password_confirm'  => 'required|same:password',
            "photo"                => "nullable|mimes:jpg,gif,jpeg,png,tiff",
            "identity_photo"                => "required|mimes:jpg,gif,jpeg,png,tiff",
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
