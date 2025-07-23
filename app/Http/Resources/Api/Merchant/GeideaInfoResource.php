<?php

namespace App\Http\Resources\Api\Merchant;


use Illuminate\Http\Resources\Json\JsonResource;


class GeideaInfoResource extends JsonResource
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
            'geidea_user_name' => $this->geidea_user_name,
            'geidea_serial_number' => $this->geidea_serial_number,
            'geidea_pass' => $this->geidea_pass,
        ];

        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}
