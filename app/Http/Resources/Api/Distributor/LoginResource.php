<?php

namespace App\Http\Resources\Api\Distributor;


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
            'identity_id'                 => $this->identity_id,
            'tax_number'                 => $this->tax_number,
            'image'                 => $this->image ?  url('/').'/uploads/distributors/'.$this->image : null,
            'identity_image'                 => $this->identity_image ?  url('/').'/uploads/distributors/'.$this->identity_image : null,
            'api_token' => $this->confirmed ? $this->token : null,
            'language' => $this->language,
            'confirmed' => $this->confirmed == 0 ? false : null,
        ];

        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}
