<?php

namespace App\Http\Resources\Api\SelfService;


use Illuminate\Http\Resources\Json\JsonResource;


class PackageResource extends JsonResource
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
            'id'         => $this->id,
            'gencode'         => $this->cards()->where('sold',0)->count() > 0 ? null : $this->gencode,
            'name'       => $this->name[app()->getLocale()],
            'description'       => $this->category->description[app()->getLocale()],
            'category_name'       => $this->category->name[app()->getLocale()],
            'company_name'       => $this->category->company->name[app()->getLocale()],
            'company_image'       =>url('/').'/uploads/stores/'. $this->category->company->image,
            'price'      =>(string)$this->card_price,

        ];

        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}
