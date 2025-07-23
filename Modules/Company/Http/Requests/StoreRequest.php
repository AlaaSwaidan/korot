<?php

namespace Modules\Company\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
                'name'              => 'required|array',
                'name.*'              => 'required|max:191',
//                'api_linked'              => 'required|max:191',
                'arrangement'              => 'required|numeric',
                'color'              => 'required',
                "photo"                => "nullable|mimes:jpg,gif,jpeg,png,tiff",
            ];
        }


        return [
            'name'              => 'required|array',
            'name.*'              => 'required|max:191',
//            'api_linked'              => 'required|max:191',
            'arrangement'              => 'required|numeric',
            'color'              => 'required',
            "photo"                => "required|mimes:jpg,gif,jpeg,png,tiff",
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
