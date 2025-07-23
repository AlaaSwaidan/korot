<?php

namespace App\Http\Resources\Api\Merchant;


use Illuminate\Http\Resources\Json\JsonResource;


class LoginResource extends JsonResource
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
            'api_token' => $this->confirmed ? $this->token : null,
            'language' => $this->language,
            'confirmed' => $this->confirmed == 0 ? false : null,
        ];

        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}
