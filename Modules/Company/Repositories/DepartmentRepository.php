<?php

namespace Modules\Company\Repositories;

use App\Models\Department;
use App\Models\Store;

class DepartmentRepository
{

    public function index()
    {
        $data = Department::orderBy('id', 'desc')
            ->paginate(20)
            ->through(function ($department) {
                $department->stores_names = Store::whereIn('id', $department->stores_id)->get(['id', 'name']);
                return $department;
            })->appends(request()->except('page'));
        return $data;
    }
    public function all_companies()
    {
        $data = Department::Order()->get();
        return $data;
    }

    public function store($request)
    {
        try {
            if ( isset($request->photo) && $request->photo ){
                $request['image'] = UploadImage($request->file('photo'), 'departments', '/uploads/departments');

            }

            $store = Department::create($request->all());
            return $store;
        } catch (\Exception $exception) {
            return redirect()->route('admin.departments.index')->with('warning', 'Error , contact system');
        }
    }

    public function update($request, $store)

    {
        try {
            if ( isset($request->photo) && $request->photo ){
                @unlink(public_path('uploads/departments/') . $store->image);
                $request['image'] = UploadImage($request->file('photo'), 'departments', '/uploads/departments');
            }
            $updated = $store->update($request->all());

            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.departments.index')->with('warning', 'Error , contact system');

        }

    }

    public function destroy($request)
    {
        try {
            $data = Department::find($request->id);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.departments.index')->with('warning', 'Error , contact system');

        }
    }
    public function destroy_selected_rows($request)
    {
        try {
            $data = Department::whereIn('id',$request->ids);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.departments.index')->with('warning', 'Error , contact system');

        }
    }



}
