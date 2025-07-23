<?php

namespace App\Http\Resources\Api\Merchant;


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
            'brand_name'                 => $this->brand_name,
            'mada_pay'                 => $this->mada_pay,
            'balance'                 => number_format($this->balance,2),
            'profits'                 => number_format($this->profits,2),
            'indebtedness'                 => number_format($this->indebtedness,2) ?? 0,
            'image'                 => $this->image ?  url('/').'/uploads/merchants/'.$this->image : null,

        ];

        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}
