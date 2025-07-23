<?php

namespace Modules\Company\Repositories;

use App\Models\Department;
use App\Models\Store;

class StoreRepository
{

    public function index()
    {
        $data = Store::Order()->Main()
            ->paginate(20)
            ->through(function ($store) {
                $store->departments = Department::whereJsonContains('stores_id', (string) $store->id)
                    ->pluck('name')
                    ->toArray(); // Ensure it returns an array
                return $store;

            })->appends(request()->except('page'));
        return $data;
    }
    public function all_companies()
    {
        $data = Store::Order()->Main()->get();
        return $data;
    }

    public function store($request)
    {
        try {
            $request['status'] = isset($request->status) ? $request->status : 0;


            if ( isset($request->photo) && $request->photo ){
                $request['image'] = UploadImage($request->file('photo'), 'stores', '/uploads/stores');

            }
            $merchantIds = $request->merchant_ids;
            $store = Store::create($request->all());
            $store->merchants()->sync($merchantIds);
            return $store;
        } catch (\Exception $exception) {
            return redirect()->route('admin.stores.index')->with('warning', 'Error , contact system');
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

            $merchantIds = $request->merchant_ids;
            $store->merchants()->sync($merchantIds);

            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.stores.index')->with('warning', 'Error , contact system');

        }

    }

    public function destroy($request)
    {
        try {
            $data = Store::find($request->id);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.stores.index')->with('warning', 'Error , contact system');

        }
    }
    public function destroy_selected_rows($request)
    {
        try {
            $data = Store::whereIn('id',$request->ids);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.stores.index')->with('warning', 'Error , contact system');

        }
    }



}
