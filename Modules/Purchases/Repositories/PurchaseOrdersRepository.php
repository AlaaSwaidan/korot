<?php

namespace Modules\Purchases\Repositories;

use App\Http\Controllers\Api\ApiController;
use App\Models\PurchaseOrder;
use App\Models\PurchaseProduct;
use App\Models\Statistic;
use App\Models\Supplier;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Validator;

class PurchaseOrdersRepository
{

    public function index($type)
    {
        $type = $type == "confirm" ? 1 : 0;
        $data = PurchaseOrder::Order()->where('confirm',$type)->paginate(20)->appends(request()->except('page'));
        return $data;
    }
    public function store($request)
    {
        try {
            $rules = [
                "supplier_id"                => "required",
//                "supplier_code"          =>"required|numeric",
                "currency_id"          =>"required",
                "purchase_order_date"          =>"required",
                "received_date"          =>"required",
                'tax_amount'=>"required|numeric",
                'total_after_tax'=>"required|numeric",
                'total_before_tax'=>"required|numeric",
                'products'=>"required|array",
                'products.*'=>"required",
                'quantity'=>"required|array",
                'quantity.*'=>"required|numeric",
                'price'=>"required|array",
                'price.*'=>"required|numeric",
                'tax'=>"required|array",
                'tax.*'=>"required|numeric",
                'total'=>"required|array",
                'total.*'=>"required|numeric",

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails())
                return [
                    'success' => 0,
                    'data' =>['success'=>0,'error'=>ApiController::respondWithErrorAdmin(validateRulesAdmin($validator->errors(), $rules))]
                ];


            $request['supplier_code']=Supplier::find($request->supplier_id)->supplier_id;

            $order = PurchaseOrder::create($request->all());
            $total_before_tax = 0;
            $total_after_tax = 0;
            $tax_amount = 0;
            $total_discount_amount = 0;
            foreach ($request->products as $key => $value){
                $total_discount_amount += (( $request->price[$key] * $request->quantity[$key]) * $request->discount_amount[$key] /100);
                $price = $request->price[$key] * $request->quantity[$key];
                $all =  $price - ($price * $request->discount_amount[$key] /100);
                $tax= $request->tax[$key] /100;
                $total_before_tax += $all;
                $tax_amount += $all * $tax;
                $total_after_tax += ($all + ($all*$tax));
                PurchaseProduct::create([
                    'purchase_order_id'=>$order->id,
                    'product_id'=>$value,
                    'quantity'=>$request->quantity[$key],
                    'choose_tax'=>$request->choose_tax[$key],
                    'price'=>$request->price[$key],
                    'tax'=>$request->tax[$key],
                    'discount_amount'=>$request->discount_amount[$key],
                    'total'=>round($all,2),
                ]);


            }
            $order->update([
                'total_before_tax'=>$total_before_tax,
                'total_after_tax'=>$total_after_tax,
                'tax_amount'=>$tax_amount,
                'total_discount_amount'=>$total_discount_amount,
                'invoice_id'=>"PO".$order->id,
            ]);
            return ['success'=>1];

        } catch (\Exception $exception) {
            return redirect()->route('admin.purchase-orders.index')->with('warning', 'Error , contact system');
        }
    }

    public function update($request, $purchaseOrder)

    {
        try {

            $rules = [
                "supplier_id"                => "required",
//                "supplier_code"          =>"required|numeric",
                "currency_id"          =>"required",
                "purchase_order_date"          =>"required",
                "received_date"          =>"required",
                'tax_amount'=>"required|numeric",
                'total_after_tax'=>"required|numeric",
                'total_before_tax'=>"required|numeric",
                'products'=>"required|array",
                'products.*'=>"required",
                'quantity'=>"required|array",
                'quantity.*'=>"required|numeric",
                'price'=>"required|array",
                'price.*'=>"required|numeric",
                'tax'=>"required|array",
                'tax.*'=>"required|numeric",
                'total'=>"required|array",
                'total.*'=>"required|numeric",

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails())
                return [
                    'success' => 0,
                    'data' =>['success'=>0,'error'=>ApiController::respondWithErrorAdmin(validateRulesAdmin($validator->errors(), $rules))]
                ];


            $request['supplier_code']=Supplier::find($request->supplier_id)->supplier_id;
            $purchaseOrder->update($request->all());
            PurchaseProduct::where('purchase_order_id',$purchaseOrder->id)->delete();
            $total_before_tax = 0;
            $total_after_tax = 0;
            $tax_amount = 0;
            $total_discount_amount = 0;
            foreach ($request->products as $key => $value){
                $total_discount_amount += (( $request->price[$key] * $request->quantity[$key]) * $request->discount_amount[$key] /100);
                $price = $request->price[$key] * $request->quantity[$key];
                $all =  $price - ($price * $request->discount_amount[$key] /100);
                $tax= $request->tax[$key] /100;
                $total_before_tax += $all;
                $tax_amount += $all * $tax;
                $total_after_tax += ($all + ($all*$tax));
                PurchaseProduct::create([
                    'purchase_order_id'=>$purchaseOrder->id,
                    'product_id'=>$value,
                    'quantity'=>$request->quantity[$key],
                    'choose_tax'=>$request->choose_tax[$key],
                    'price'=>$request->price[$key],
                    'tax'=>$request->tax[$key],
                    'discount_amount'=>$request->discount_amount[$key],
                    'total'=>round($all,2),
                ]);


            }
            $purchaseOrder->update([
                'total_before_tax'=>$total_before_tax,
                'total_after_tax'=>$total_after_tax,
                'total_discount_amount'=>$total_discount_amount,
                'tax_amount'=>$tax_amount,
            ]);

            return ['success'=>1];
        } catch (\Exception $exception) {
            return redirect()->route('admin.purchase-orders.index')->with('warning', 'Error , contact system');

        }

    }
    public function confirm($request, $purchaseOrder)

    {
        try {

            $rules = [
                "supplier_id"                => "required",
//                "supplier_code"          =>"required|numeric",
                "currency_id"          =>"required",
                "purchase_order_date"          =>"required",
                "received_date"          =>"required",
                'tax_amount'=>"required|numeric",
                'total_after_tax'=>"required|numeric",
                'total_before_tax'=>"required|numeric",
                'products'=>"required|array",
                'products.*'=>"required",
                'quantity'=>"required|array",
                'quantity.*'=>"required|numeric",
                'price'=>"required|array",
                'price.*'=>"required|numeric",
                'tax'=>"required|array",
                'tax.*'=>"required|numeric",
                'total'=>"required|array",
                'total.*'=>"required|numeric",
                "bank_id"                => "required",
                "confirm_date"                => "required",

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails())
                return [
                    'success' => 0,
                    'data' =>['success'=>0,'error'=>ApiController::respondWithErrorAdmin(validateRulesAdmin($validator->errors(), $rules))]
                ];


            $request['supplier_code']=Supplier::find($request->supplier_id)->supplier_id;
            $purchaseOrder->update($request->all());
            PurchaseProduct::where('purchase_order_id',$purchaseOrder->id)->delete();
            $total_before_tax = 0;
            $total_after_tax = 0;
            $tax_amount = 0;
            $total_discount_amount = 0;
            foreach ($request->products as $key => $value){
                $total_discount_amount += (( $request->price[$key] * $request->quantity[$key]) * $request->discount_amount[$key] /100);
                $price = $request->price[$key] * $request->quantity[$key];
                $all =  $price - ($price * $request->discount_amount[$key] /100);
                $tax= $request->tax[$key] /100;
                $total_before_tax += $all;
                $tax_amount += $all * $tax;
                $total_after_tax += ($all + ($all*$tax));
                PurchaseProduct::create([
                    'purchase_order_id'=>$purchaseOrder->id,
                    'product_id'=>$value,
                    'quantity'=>$request->quantity[$key],
                    'choose_tax'=>$request->choose_tax[$key],
                    'price'=>$request->price[$key],
                    'tax'=>$request->tax[$key],
                    'discount_amount'=>$request->discount_amount[$key],
                    'total'=>round($all,2),
                ]);

                if($value == "digital_balance"){
                    $statistics = Statistic::find(1);
                    $statistics->update([
                        'digital_balance'=> $statistics->digital_balance + $all
                    ]);
                }


            }
            $purchaseOrder->update([
                'total_before_tax'=>$total_before_tax,
                'total_after_tax'=>$total_after_tax,
                'tax_amount'=>$tax_amount,
                'bank_id'=>$request->bank_id,
                'total_discount_amount'=>$total_discount_amount,
                'confirm'=>1,
                'invoice_id'=>"PO".$purchaseOrder->id,
            ]);
            add_journals($purchaseOrder->id,"purchases");
            return ['success'=>1];
        } catch (\Exception $exception) {
            return redirect()->route('admin.purchase-orders.index')->with('warning', 'Error , contact system');

        }

    }

    public function destroy($request)
    {
        try {
            $data = PurchaseOrder::find($request->id);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.purchase-orders.index')->with('warning', 'Error , contact system');

        }
    }
    public function destroy_selected_rows($request)
    {
        try {
            $data = PurchaseOrder::whereIn('id',$request->ids);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.purchase-orders.index')->with('warning', 'Error , contact system');

        }
    }

}
