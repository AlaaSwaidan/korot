<?php

namespace App\Http\Resources\Api\Merchant;


use Illuminate\Http\Resources\Json\JsonResource;


class TransactionsResource extends JsonResource
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
            'balance' => number_format($this->balance,2),
            'indebtedness' => number_format($this->indebtedness,2),
            'date' => $this->created_at->locale(app()->getLocale())->isoFormat('Do MMM, Y ,h:mm A') ,
            'transactions'                 => AllTransactionsResource::collection($this->userable()->Order()->where('paid_order','paid')->where('confirm',1)->take(10)->get()),

        ];

        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}
