<?php

namespace App\Http\Resources\Api\Distributor;


use App\Http\Resources\Api\Merchant\AllTransactionsResource;
use Illuminate\Http\Resources\Json\JsonResource;


class HomeResource extends JsonResource
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
            'is_active'=>!$this->is_inactive,
            'brand_name'=>$this->brand_name,
            'date' => $this->created_at->locale(app()->getLocale())->isoFormat('Do MMM, Y ,h:mm A') ,

        ];

        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}
