<?php

namespace Modules\SuperAdmin\Repositories;

use App\Models\Admin;
use Spatie\Permission\Models\Role;

class SuperAdminRepository
{

    public function index()
    {
        $data = Admin::Type()->Order()->paginate(20)->appends(request()->except('page'));
        return $data;
    }

    public function store($request)
    {
        try {
            $request['status'] = isset($request->status) ? $request->status : 0;

            $request['type'] = "super_admin";
            $admin = Admin::create($request->all());
            $superRole = Role::where('name','super-admin')->first();
            $admin->syncRoles($superRole);


            return $admin;
        } catch (\Exception $exception) {
            return redirect()->route('admin.super-admins.index')->with('warning', 'Error , contact system');
        }
    }

    public function update($request, $superAdmin)

    {
        try {
            $request['status'] = isset($request->status) ? $request->status : 0;
            $updated = $superAdmin->update($request->all());

            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.super-admins.index')->with('warning', 'Error , contact system');

        }

    }

    public function destroy($request)
    {
        try {
            $data = Admin::find($request->id);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.super-admins.index')->with('warning', 'Error , contact system');

        }
    }

    public function update_password($request, $superAdmin)
    {
        try {
            $updated = $superAdmin->update(['password' => $request->new_password]);
            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.super-admins.index')->with('warning', 'Error , contact system');

        }
    }

}
