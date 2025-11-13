<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NewExternalMerchantServiceResource extends JsonResource
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

                'id'=>$this->id,
                'name'=>$this->name,
                'tax_number'=>$this->tax_number,
                'registration_number'=>$this->commercial_number,
                'location'=>$this->location,
                'region'=>$this->region_id,
                'city'=>$this->city_id ?$this->city->name_ar : null ,
                'street'=>$this->street,
                'distinct'=>$this->distinct,
                'zipcode'=>$this->zipcode,
                'building_number'=>$this->building_number,
                'extra_number'=>$this->extra_number,





        ];
        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}

