<?php

namespace Modules\Role\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == 'PATCH') {

            $id = request()->segment(3);

            return [
                'name' => 'required|unique:roles,name,' . $id,
                'permissions' => 'required',
                'permissions.*' => 'required|exists:permissions,id',
            ];
        }


        return [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
            'permissions.*' => 'required|exists:permissions,id',
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
