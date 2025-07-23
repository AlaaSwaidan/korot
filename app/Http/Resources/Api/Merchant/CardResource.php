<?php

namespace App\Http\Resources\Api\Merchant;


use Illuminate\Http\Resources\Json\JsonResource;


class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        $merchant = auth()->guard('api_merchant')->user();
        if ($new_price =$merchant->prices()->where('package_id',$this->package->id)->where('type',$merchant->type)->first()){
            $merchant_price = $new_price->price;
        }
        $new_price = isset($merchant_price) ? $merchant_price :  $this->package->prices()->where('type',$merchant->type)->first()->price;
        return [
            'card_number'      =>$this->card_number,
            'serial_number'      =>$this->serial_number,
            'end_date'      =>$this->end_date,
            'terminal_id'      =>$request['transaction_id'],
            'card_qrcode' => (string) ($this->package->category->charge_info ? "tel:" . str_replace("parameter", $this->card_number, $this->package->category->charge_info) : ''),


        ];

      /*  return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });*/
    }
}
