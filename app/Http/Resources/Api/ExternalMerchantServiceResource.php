<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ExternalMerchantServiceResource extends JsonResource
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

                'id'=>$this->merchant->id,
                'name'=>$this->merchant->name,
                'tax_number'=>$this->merchant->tax_number,
                'registration_number'=>$this->merchant->commercial_number,
                'location'=>$this->merchant->location,
                'region'=>$this->merchant->region_id,
                'city'=>$this->merchant->city_id ?$this->merchant->city->name_ar : null ,
                'street'=>$this->merchant->street,
                'distinct'=>$this->merchant->distinct,
                'zipcode'=>$this->merchant->zipcode,
                'building_number'=>$this->merchant->building_number,
                'extra_number'=>$this->merchant->extra_number,





        ];
        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}

