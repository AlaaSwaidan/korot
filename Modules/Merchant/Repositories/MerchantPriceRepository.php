<?php

namespace Modules\Merchant\Repositories;

use App\Models\Merchant;
use App\Models\Package;
use App\Models\Store;
use Modules\Merchant\Entities\MerchantPrice;

class MerchantPriceRepository
{

    public function index($merchant)
    {
        $data = $merchant->prices()->Order()->get();
        return $data;
    }

    public function search($filter,$updated)
    {
        $stores = Store::where('parent_id',$filter->company_name)->pluck('id')->toArray();

        $result =Package::whereIn('store_id',$stores)->whereNotIn('id',$updated->pluck('package_id')->toArray())
            ->when($filter->package_name, function ($q) use ($filter) {
                return $q->where(function ($q2) use ($filter) {
                    $q2->where('id', 'LIKE', "%$filter->package_name%");
                });
        })->get();
        return $result;
    }

    public function store($request)
    {
    }

    public function update($request, $merchant)

    {
        try {

            if ($request->price){
                foreach ($request->price as $key1 => $value1){
                    if ($value1 != null){
                        $updated=  MerchantPrice::where('merchant_id',$merchant->id)->where('id',$request->id[$key1])->update([
                            'price'=>$value1,
                        ]);
                    }

                }
            }if($request->new_price){

                foreach ($request->new_price as $key => $value){
                    if ($value != null){

                        $package = Package::find($request->package_id[$key]);
                        $updated= MerchantPrice::create([
                            'added_by'=>auth()->guard('admin')->user()->id,
                            'merchant_id'=>$merchant->id,
                            'package_id'=>$request->package_id[$key],
                            'old_price'=>$package->prices()->where('type',$merchant->type)->first()->price,
                            'price'=>$value,
                            'type'=>$merchant->type,
                        ]);
                    }

                }
            }



            return  $merchant;
        } catch (\Exception $exception) {
            return redirect()->route('admin.merchants.index')->with('warning', 'Error , contact system');

        }

    }


    public function destroy_selected_rows($request)
    {
        try {

            $data = MerchantPrice::whereIn('id',$request->ids);
            $url = route('admin.merchants.prices',$data->first()->merchant_id);
            $deleted = $data->delete();
            return $url;
        } catch (\Exception $exception) {
            return redirect()->route('admin.merchants.index')->with('warning', 'Error , contact system');

        }
    }
    public function profile_destroy_selected_rows($request)
    {
        try {

            $data = MerchantPrice::whereIn('id',$request->ids);
            $url = route('admin.merchants.profile-prices',$data->first()->merchant_id);
            $deleted = $data->delete();
            return $url;
        } catch (\Exception $exception) {
            return redirect()->route('admin.merchants.index')->with('warning', 'Error , contact system');

        }
    }
}
