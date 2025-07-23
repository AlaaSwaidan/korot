<?php

namespace App\Http\Resources\Api\Merchant;


use App\Models\Order;
use App\Services\CodeService;
use Illuminate\Http\Resources\Json\JsonResource;


class MyOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        $code = $this->package->barcode ? $this->package->barcode : CodeService::generateUniqueCode($this->package);

        return [


                'merchant'=>[
                    'id'=>$this->merchant->id,
                    'name'=>$this->merchant->name
                ],
                'terminal_id'=>$this->transaction_id,
                'order_id' => $this->id,
                'barcode'      =>'*'.$code.'*',
                'package_name'                 => $this->name[app()->getLocale()],
                'category_name'                 => $this->package->category->name[app()->getLocale()],
                'description'                 => $this->description[app()->getLocale()],
                'company_name'                 => $this->company_name[app()->getLocale()],
                'price'      =>(string)$this->card_price,
                'merchant_price'      =>(string)$this->merchant_price,
                'paid_status'      =>$this->paid_order,
                'image'      =>url('/').'/uploads/stores/'.$this->image,
                'color'      =>$this->color,
                'transaction_id'      =>$this->transaction_id,
                'total_price'      =>(string)$this->total,
                'total_cards'      =>(string)Order::where('parent_id',$this->id)->count(),
                'print_status'      =>(int)$this->print_status,
//                'cards'=>$this->paid_order == "not_paid" ? [
//                    'card_number'=>null,
//                    'serial_number'=>null,
//                    'end_date'=>null,
//                    'print_status'=>null,
//                    'transaction_id'=>null,
//                ] : Order::where('parent_id',$this->id)->select('card_number','serial_number','end_date','print_status','transaction_id','id as card_id')->get(),

                'created_at'      =>$this->created_at->locale(app()->getLocale())->isoFormat('Do/MM/Y ,h:mm A'),



        ];

//        return   array_filter($data, function($value) {
//            return $value !== null && $value !== '' && $value !== "" ;
//        });
    }
}
