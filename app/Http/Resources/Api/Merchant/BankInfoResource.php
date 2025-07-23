<?php

namespace App\Http\Resources\Api\Merchant;


use Illuminate\Http\Resources\Json\JsonResource;


class BankInfoResource extends JsonResource
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
            'bank_name'       => $this->bank_name[app()->getLocale()],
            'bank_address'       => $this->bank_address[app()->getLocale()],
            'account_number'      =>$this->account_number,
            'code'      =>$this->bank_code,

        ];

        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}
