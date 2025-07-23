<?php

namespace Modules\Admin\Repositories;

use App\Models\Admin;
use Spatie\Permission\Models\Role;

class AdminRepository
{

    public function index()
    {
        $data = Admin::where('type', 'admin')->Order()->paginate(20)->appends(request()->except('page'));
        return $data;
    }

    public function store($request)
    {
        try {
            $request['status'] = isset($request->status) ? $request->status : 0;

            $request['type'] = "admin";
            $admin = Admin::create($request->all());
            $superRole = Role::where('id',$request->roles)->first();
            $admin->syncRoles($superRole);
            return $admin;
        } catch (\Exception $exception) {
            return redirect()->route('admin.admins.index')->with('warning', 'Error , contact system');
        }
    }

    public function update($request, $admin)

    {
        try {
            $request['status'] = isset($request->status) ? $request->status : 0;
            $updated = $admin->update($request->all());
            $superRole = Role::where('id',$request->roles)->first();
            $admin->syncRoles($superRole);
            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.admins.index')->with('warning', 'Error , contact system');

        }

    }

    public function destroy($request)
    {
        try {
            $data = Admin::find($request->id);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.admins.index')->with('warning', 'Error , contact system');

        }
    }
    public function destroy_selected_rows($request)
    {
        try {
            $deleted = Admin::whereIn('id',$request->ids)->where('id','!=',null)->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.admins.index')->with('warning', 'Error , contact system');

        }
    }

    public function update_password($request, $admin)
    {
        try {
            $updated = $admin->update(['password' => $request->new_password]);
            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.admins.index')->with('warning', 'Error , contact system');

        }
    }

}
