<?php

namespace App\Http\Resources\Api\Merchant;


use Illuminate\Http\Resources\Json\JsonResource;


class CreditTransactionsResource extends JsonResource
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
            'id'                 => $this->id ,
            'name'                 => trans('api.recharge'),
            'amount'                 => $this->amount ,
//            'confirm'                 => $this->confirm ,
            'paid_order'                 => $this->paid_order ,
            'transaction_id'                 => $this->transaction_id ,
            'geidea_percentage'                 => $this->geidea_percentage ,
            'geidea_commission'                 => $this->geidea_commission ,
            'type'            => getPayType( $this->pay_type) ,
            'pay_type'            =>  $this->pay_type ,
            'date'                 => $this->created_at->locale(app()->getLocale())->isoFormat('Do MMMM, Y') ,

        ];

        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}
