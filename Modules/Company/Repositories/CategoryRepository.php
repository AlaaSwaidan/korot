<?php

namespace Modules\Company\Repositories;

use App\Models\Package;
use App\Models\PackagePrice;
use App\Models\Store;

class CategoryRepository
{

    public function index($company)
    {
        $data = $company->categories()->Order()->paginate(20)->appends(request()->except('page'));
        return $data;
    }

    public function store($request,$company)
    {
        try {
            if ( isset($request->photo) && $request->photo ){
                $request['image'] = UploadImage($request->file('photo'), 'stores', '/uploads/stores');
            }
            $request['parent_id']=$company->id;
            $store = Store::create($request->all());
            return $store;
        } catch (\Exception $exception) {
            return redirect()->route('admin.categories.index')->with('warning', 'Error , contact system');
        }
    }

    public function update($request, $store)

    {
        try {
            if ( isset($request->photo) && $request->photo ){
                @unlink(public_path('uploads/stores/') . $store->image);
                $request['image'] = UploadImage($request->file('photo'), 'stores', '/uploads/stores');
            }
            $request['status'] = isset($request->status) ? $request->status : 0;
            $updated = $store->update($request->all());



            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.categories.index')->with('warning', 'Error , contact system');

        }

    }

    public function destroy($request)
    {
        try {

            $data = Store::find($request->id);
            $url = route('admin.categories.index',$data->parent_id);
            $deleted = $data->delete();
            return $url;
        } catch (\Exception $exception) {
            return redirect()->route('admin.categories.index')->with('warning', 'Error , contact system');

        }
    }
    public function destroy_selected_rows($request)
    {
        try {

            $data = Store::whereIn('id',$request->ids);
            $url = route('admin.categories.index',$data->first()->parent_id);
            $deleted = $data->delete();
            return $url;
        } catch (\Exception $exception) {
            return redirect()->route('admin.categories.index')->with('warning', 'Error , contact system');

        }
    }



}
