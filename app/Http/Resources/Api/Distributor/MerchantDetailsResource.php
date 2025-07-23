<?php

namespace App\Http\Resources\Api\Distributor;


use App\Http\Resources\Api\Distributor\MerchantTransactionsResource;
use App\Models\DistributorIndebtedness;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Modules\Transfers\Entities\Transfer;


class MerchantDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
//dd($request->all());
        $transactions =  $this->userable()->Order()->where('providerable_type','App\Models\Distributor')
            ->where('providerable_id',auth()->guard('api_distributor')->user()->id)
            ->where('confirm',1);
        $check = DistributorIndebtedness::where('distributor_id',auth()->guard('api_distributor')->user()->id)
            ->where('merchant_id',$this->id);
        $transfer_total = $this->transfer_total;
        $collection_total = $this->collection_total;
        $balance = $this->balance;
        $profits = $this->profits;
        $sales = $this->sales;
        $orders = $this->orders()->where('paid_order',"paid")->where('parent_id','!=',null);
        $startDate = $request->from_date;
        $endDate = $request->to_date;
        if ($request->from_date && $request->to_date){
            $transactions = $transactions
                ->whereBetween(\DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]);
            $check = $check->whereBetween(\DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]);
            $orders = $orders->whereBetween(\DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]);
            $balance = (clone $transactions)->latest()->first() ? (clone $transactions)->latest()->first()->balance_total : 0;
            $transfer_total = (clone $transactions)->where('type','transfer')->sum('amount');
            $collection_total = (clone $transactions)->where('type','collection')->sum('amount');
//            $profits = (clone $transactions)->where('type','profits')->sum('amount') +  (clone $transactions)->where('type','sales')->sum('profits');
            $sales = (clone $orders)->sum('card_price');

            $all = $orders->get()->unique('package_id')->map(function ($all_transactions) use ($startDate,$endDate){
                $orders =$all_transactions->where('parent_id','!=',null)
                    ->where('paid_order',"paid")
                    ->where('merchant_id',$this->id)->where('package_id',$all_transactions->package_id)
                    ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
                $commission = Transfer::whereOrderId($all_transactions->id)->first();
                $merchant_price =$orders->sum('merchant_price');
                $geidea_commission =$commission ? $commission->geidea_commission : 0;
                $total =$orders->sum('card_price') - $merchant_price  - $geidea_commission;
                $all_transactions['profits']=($total);
                return $all_transactions;
            });
            $profits = $all->sum('profits');
        }

        if ($request->from_date  && $request->to_date == null){
            $transactions = $transactions->whereDate('created_at',$request->from_date);
            $check = $check->whereDate('created_at',$request->from_date);
            $orders = $orders->whereDate('created_at',$request->from_date);
            $balance = (clone $transactions)->latest()->first() ? (clone $transactions)->latest()->first()->balance_total : 0;
            $transfer_total = (clone $transactions)->where('type','transfer')->sum('amount');
            $collection_total = (clone $transactions)->where('type','collection')->sum('amount');
//            $profits = (clone $transactions)->where('type','profits')->sum('amount') +  (clone $transactions)->where('type','sales')->sum('profits');
            $sales = (clone $orders)->sum('card_price');

            $all = $orders->get()->unique('package_id')->map(function ($all_transactions) use ($startDate){
                $orders =$all_transactions->where('parent_id','!=',null)
                    ->where('paid_order',"paid")
                    ->where('merchant_id',$this->id)->where('package_id',$all_transactions->package_id)
                    ->whereDate('created_at',$startDate);
                $commission = Transfer::whereOrderId($all_transactions->id)->first();
                $merchant_price =$orders->sum('merchant_price');
                $geidea_commission =$commission ? $commission->geidea_commission : 0;
                $total =$orders->sum('card_price') - $merchant_price  - $geidea_commission;
                $all_transactions['profits']=($total);
                return $all_transactions;
            });
            $profits = $all->sum('profits');
        }



        $transactions = $transactions->take(10)->get();
        $orders = $orders->count();
        $check = $check->first();
        $data= [
            'id'=>$this->id,
            'name'=>$this->name,
            'brand_name'=>$this->brand_name,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'indebtedness'=>number_format(($check ? $check->total : 0),2),
            'transfer_total'=>number_format($transfer_total,2),
            'collection_total'=>number_format($collection_total,2),
            'balance'=>number_format($balance,2),
            'profits'=>number_format($profits,2),
            'sales_total'=>number_format($sales,2),
            'card_numbers'=>$orders,
            'date' => $this->created_at->locale(app()->getLocale())->isoFormat('Do MMM, Y ,h:mm A') ,
            'transactions'                 => MerchantTransactionsResource::collection($transactions),

        ];

        return   array_filter($data, function($value) {
            return $value !== null && $value !== '' && $value !== "" ;
        });
    }
}
