<?php

namespace Modules\Company\Repositories;

use App\Models\Package;
use App\Models\PackagePrice;
use App\Models\Store;
use Modules\Merchant\Entities\MerchantPrice;

class PackageRepository
{

    public function index($category)
    {
        $data = $category->packages()->Order()->paginate(20)->appends(request()->except('page'));
        return $data;
    }

    public function store($request,$category)
    {
        try {
            $request['store_id']=$category->id;
            $request['status'] = isset($request->status) ? $request->status : 0;
            $request['gencode_like_card_status'] = isset($request->gencode_like_card_status) ? $request->gencode_like_card_status : 0;
            $request['gencode_status'] = isset($request->gencode_status) ? $request->gencode_status : 0;
            $package = Package::create($request->all());

            foreach ($request->type as $key => $value){
                PackagePrice::create([
                    'package_id'=>$package->id,
                    'type'=>$key,
                    'price'=>$value,
                ]);
            }

            return $package;
        } catch (\Exception $exception) {
            return redirect()->route('admin.packages.index')->with('warning', 'Error , contact system');
        }
    }

    public function update($request, $package)

    {
        try {

            $request['status'] = isset($request->status) ? $request->status : 0;
            $request['gencode_like_card_status'] = isset($request->gencode_like_card_status) ? $request->gencode_like_card_status : 0;
            $request['gencode_status'] = isset($request->gencode_status) ? $request->gencode_status : 0;
            $updated = $package->update($request->all());

            PackagePrice::where('package_id',$package->id)->delete();
            foreach ($request->type as $key => $value){
                PackagePrice::create([
                    'package_id'=>$package->id,
                    'type'=>$key,
                    'price'=>$value,
                ]);
                MerchantPrice::where('package_id',$package->id)->where('type',$key)->where('old_price','!=',$value)
                    ->update([
                        'old_price'=>$value,
                        'price'=>$value
                    ]);
            }

            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.packages.index')->with('warning', 'Error , contact system');

        }

    }

    public function destroy($request)
    {
        try {

            $data = Package::find($request->id);
            $url = route('admin.packages.index',$data->store_id);
            $deleted = $data->delete();
            return $url;
        } catch (\Exception $exception) {
            return redirect()->route('admin.packages.index')->with('warning', 'Error , contact system');

        }
    }
    public function destroy_selected_rows($request)
    {
        try {

            $data = Package::whereIn('id',$request->ids);
            $url = route('admin.packages.index',$data->first()->store_id);
            // Delete all packages
            Package::whereIn('id', $request->ids)->delete();

            return $url;
        } catch (\Exception $exception) {
            return redirect()->route('admin.packages.index')->with('warning', 'Error , contact system');

        }
    }



}
