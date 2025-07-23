<?php

namespace Modules\Company\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
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
                'serial_number'              => 'required|numeric',
                'end_date'              => 'required',
                'card_number'             => 'required|unique:cards,card_number,'. $this->card->id,

            ];
        }


        return [
            'serial_number'              => 'required|numeric',
            'card_number'              => 'required|unique:cards',
            'end_date'              => 'required',
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
