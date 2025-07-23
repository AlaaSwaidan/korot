<?php

namespace App\Http\Resources\Api\Merchant;


use App\Models\Package;
use App\Services\CodeService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;


class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {

        $merchant =  auth()->guard('api_merchant')->user();
        if ($new_price =$merchant->prices()->where('package_id',$this->id)->where('type',$merchant->type)->first()){
            $merchant_price = $new_price->price;
        }
        $code = $this->barcode ? $this->barcode : CodeService::generateUniqueCode($this);

        $data= [
            'id'         => $this->id,
            'gencode'         => $this->cards()->where('sold',0)->count() > 0 ? null : $this->gencode,
            'name'       => $this->name[app()->getLocale()],
            'info'       =>$this->description ?  $this->description[app()->getLocale()] : null,
            'description'       => $this->category->description[app()->getLocale()],
            'company_name'       => $this->category->company->name[app()->getLocale()],
            'price'      =>(string)$this->card_price,
            'barcode'      =>'*'.$code.'*',
            'merchant_price'      => isset($merchant_price) ? number_format($merchant_price,2) :  number_format($this->prices()->where('type',$merchant->type)->first()->price,2),

        ];

        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }

}
