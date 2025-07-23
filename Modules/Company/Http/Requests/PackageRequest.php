<?php

namespace Modules\Company\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
                'type'              => 'required|array',
                'type.*'              => 'required',
                'name'              => 'required|array',
                'name.*'              => 'required|max:191',
                'description'              => 'required|array',
                'description.*'              => 'required|max:255',
                'arrangement'              => 'required|numeric',
                'card_price'              => 'required|numeric',
                'cost'              => 'required|numeric',
                'barcode'              => 'required|unique:packages,barcode,'.$this->package->id,
            ];
        }


        return [
            'type'              => 'required|array',
            'type.*'              => 'required',
            'name'              => 'required|array',
            'name.*'              => 'required|max:191',
            'description'              => 'required|array',
            'description.*'              => 'required|max:255',
            'arrangement'              => 'required|numeric',
            'card_price'              => 'required|numeric',
            'cost'              => 'required|numeric',
            'barcode'              => 'required|unique:packages,barcode',
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
