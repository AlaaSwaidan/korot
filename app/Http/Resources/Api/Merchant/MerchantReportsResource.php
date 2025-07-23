<?php

namespace App\Http\Resources\Api\Merchant;


use Illuminate\Http\Resources\Json\JsonResource;


class MerchantReportsResource extends JsonResource
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
            'package_name'                 =>$this->company_name[app()->getLocale()].' - '.$this->package->category->name[app()->getLocale()].' - '.$this->name[app()->getLocale()],
            'quantity'                 => $this->total_count,
            'merchant_price'      =>number_format($this->merchant_price,2),
            'profits'      =>number_format($this->profits,2),

        ];

        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}
