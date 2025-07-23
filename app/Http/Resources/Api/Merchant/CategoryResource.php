<?php

namespace App\Http\Resources\Api\Merchant;


use Illuminate\Http\Resources\Json\JsonResource;


class CategoryResource extends JsonResource
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
            'image'                 => url('/').'/uploads/stores/'. $this->image,

        ];

        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}
