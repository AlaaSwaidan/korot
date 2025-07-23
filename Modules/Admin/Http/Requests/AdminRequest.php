<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
                'email'             => 'required|email|max:191|unique:admins,email,'. $this->admin->id,
                'phone'             => 'required|numeric|unique:admins,phone,'. $this->admin->id,
                'roles'             => 'nullable',
                'status'             => 'nullable',

            ];
        }


        return [
            'name'              => 'required|max:191',
            'email'             => 'required|email|max:191|unique:admins',
            'phone'             => 'required|unique:admins|numeric',
            'roles'             => 'required',
            'status'             => 'nullable',
            'password'          => 'required|min:3|max:191',
            'password_confirm'  => 'required|same:password',
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
