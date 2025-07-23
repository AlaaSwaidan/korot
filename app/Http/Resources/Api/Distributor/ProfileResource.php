<?php

namespace App\Http\Resources\Api\Distributor;


use Illuminate\Http\Resources\Json\JsonResource;


class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function __construct($resource, $token = null)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;

        $this->token = $token;
    }
    public function toArray($request)
    {

        $data= [
            'id' => $this->id,
            'phone'                 => (string)$this->phone,
            'name'                 => $this->name,
            'email'                 => $this->email,
            'balance'                 => number_format($this->balance,2),
            'profits'                 => number_format($this->profits,2),
            'repayment_total'                 => number_format($this->repayment_total,2),
            'indebtedness'                 => number_format($this->indebtedness,2) ?? 0,
            'image'                 => $this->image ?  url('/').'/uploads/distributors/'.$this->image : null,

            'identity_id'                 => $this->identity_id,
            'tax_number'                 => $this->tax_number,
            'identity_image'                 => $this->identity_image ?  url('/').'/uploads/distributors/'.$this->identity_image : null,
        ];

        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}
