<?php

namespace App\Http\Resources\Api\Distributor;


use Illuminate\Http\Resources\Json\JsonResource;


class AllTransactionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */

    public function toArray($request)
    {

        if ($this->type == "payment") {
            $name = trans('api.payment');
        } else if ($this->type == "recharge") {
            $name = trans('api.recharge');
        } else if ($this->type == "sales") {
            $name = trans('api.sales');
        } else if ($this->type == "collection") {
            $name = trans('api.collection');
        } else if ($this->type == "transfer") {
            $name = trans('api.transfer');
        } else if ($this->type == "indebtedness") {
            $name = trans('api.indebtedness');
        } else if ($this->type == "repayment") {
            $name = trans('api.repayment');
        } else if ($this->type == "profits") {
            $name = trans('api.profits');
        } else {
            $name = trans('api.debit');
        }
        $data = [
            'id'            => $this->id,
            'merchant_name' => $this->merchant->name,
            'name'          => $name,
            'amount'        => (string)$this->amount,
            'added_by'      => getAddedBy($this->type, $this),
            'type'          => $this->pay_type,
            'date'          => $this->created_at->locale(app()->getLocale())->isoFormat('Do MMM, Y ,h:mm A'),

        ];

        return array_filter($data, function ($value) {
            return $value !== null && $value !== '' && $value !== "";
        });
    }
}
