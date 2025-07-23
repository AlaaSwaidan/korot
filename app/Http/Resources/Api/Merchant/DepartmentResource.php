<?php

namespace App\Http\Resources\Api\Merchant;


use Illuminate\Http\Resources\Json\JsonResource;


class DepartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {

        $data= [
            'id' => $this->id,
            'name'                 => $this->name[app()->getLocale()],
            'image'                 => url('/').'/uploads/departments/'. $this->image,
            'color'                 =>$this->color,

        ];

        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}
