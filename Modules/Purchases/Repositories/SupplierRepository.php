<?php

namespace Modules\Purchases\Repositories;

use App\Models\Supplier;
use Carbon\Carbon;

class SupplierRepository
{

    public function index()
    {
        $data = Supplier::Order()->paginate(20)->appends(request()->except('page'));
        return $data;
    }
    public function store($request)
    {
        try {

            $get_suppliers = Supplier::orderBy('id','desc')->first();
            $code =$get_suppliers ? $get_suppliers->supplier_id + 1 :1;
            $request['supplier_id']=$code;

            $supplier = Supplier::create($request->all());
            return $supplier;

        } catch (\Exception $exception) {
            return redirect()->route('admin.suppliers.index')->with('warning', 'Error , contact system');
        }
    }

    public function update($request, $supplier)

    {
        try {

            $updated = $supplier->update($request->all());
            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.suppliers.index')->with('warning', 'Error , contact system');

        }

    }

    public function destroy($request)
    {
        try {
            $data = Supplier::find($request->id);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.suppliers.index')->with('warning', 'Error , contact system');

        }
    }
    public function destroy_selected_rows($request)
    {
        try {
            $data = Supplier::whereIn('id',$request->ids);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.suppliers.index')->with('warning', 'Error , contact system');

        }
    }

}
