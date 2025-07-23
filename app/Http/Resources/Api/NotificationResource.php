<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'id' => $this->id,
            'type' => $this->type,
            'title' => unserialize($this->title)[app()->getLocale()],
            'message' => unserialize($this->message)[app()->getLocale()],
            'created_at' => $this->created_at,
            'date' => Carbon::parse($this->created_at)->diffForHumans(),
            'seen' => $this->seen,
            'user_id' => $this->userable_id,
        ];
        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}

