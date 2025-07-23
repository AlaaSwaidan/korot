<?php

namespace Modules\Merchant\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchantGeideaRequest extends FormRequest
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
                'geidea_pass'              => 'required|max:191',
                'geidea_user_name'             => 'required|max:191',
                'geidea_serial_number'             => 'required|unique:merchants,geidea_serial_number,'. $this->merchant->id,
            ];
        }


        return [
            'geidea_pass'              => 'required|max:191',
            'geidea_user_name'             => 'required|max:191',
            'geidea_serial_number'             => 'required|unique:merchants',

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
