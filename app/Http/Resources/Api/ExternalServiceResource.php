<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ExternalServiceResource extends JsonResource
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
//            'id' => $this->id,
//            'transaction_id' => $this->transaction_id ? json_decode($this->transaction_id) : null,
            'id'=>$this->merchant->id,
            'name'=>$this->merchant->name,
            'phone'=>$this->merchant->phone,
//            'tax_number'=>$this->merchant->tax_number,
//            'registration_number'=>$this->merchant->commercial_number,
            'location'=>$this->merchant->location,
            'region'=>$this->merchant->region_id,
            'city'=>$this->merchant->city_id ?$this->merchant->city->name_ar : null ,
            'street'=>$this->merchant->street,
            'distinct'=>$this->merchant->distinct,
            'zipcode'=>$this->merchant->zipcode,
            'building_number'=>$this->merchant->building_number,
            'extra_number'=>$this->merchant->extra_number,
           'item'=>[
               'item_code' =>$this->package_id ,
               'item_name' =>$this->company_name[app()->getLocale()] .'  '.$this->package->category->name[app()->getLocale()].'  '.$this->package->name[app()->getLocale()],
               'card_name' =>$this->name[app()->getLocale()] ,
               'merchant_price' => round($this->total_price,2),
               'quantity' => round($this->total_quantity,2),
            ],

//            'company'=>[
//                'name'=>"مؤسسة بطاقات التجارية",
//                'tax_number'=>"300453343300003",
//                'location'=>"الهفوف شارع أبوبكر",
//            ],

//            'card_number' => $this->card_number,
//            'serial_number' => $this->serial_number,
//            'card_price' => $this->card_price,

//            'end_date' => $this->end_date,
//            'created_at' => $this->created_at->format('Y-m-d'),

        ];
        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}

