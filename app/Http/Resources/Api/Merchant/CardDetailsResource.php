<?php

namespace App\Http\Resources\Api\Merchant;


use Illuminate\Http\Resources\Json\JsonResource;


class CardDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'card_id'      =>$this->id,
            'card_number'      =>$this->card_number,
            'serial_number'      =>$this->serial_number,
            'end_date'      =>$this->end_date,
            'transaction_id'      =>$this->transaction_id,
            'print_status'      =>$this->print_status,
            'price'      =>(string)$this->card_price,
            'merchant_price'      =>(string)$this->merchant_price,
            'card_qrcode' => (string) ($this->package->category->charge_info ? "tel:" . str_replace("parameter", $this->card_number, $this->package->category->charge_info) : ''),



        ];

      /*  return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });*/
    }
}
