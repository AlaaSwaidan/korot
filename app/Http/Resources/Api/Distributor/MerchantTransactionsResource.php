<?php

namespace App\Http\Resources\Api\Distributor;


use Illuminate\Http\Resources\Json\JsonResource;


class MerchantTransactionsResource extends JsonResource
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
            'merchant_name'                 => $this->merchant->name ,
            'name'                 => $this->type == "collection" ? trans('api.collection') : trans('api.transfer'),
            'amount'                 => (string)$this->amount ,
            'date'                 => $this->created_at->locale(app()->getLocale())->isoFormat('Do MMM, Y ,h:mm A') ,
            'pdf_link'       => $this->type == "collection" ? url('/').'/api/pdf-collection/'.base64_encode($this->id) :  url('/').'/api/pdf-transfer/'.base64_encode($this->id),

        ];

        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}
