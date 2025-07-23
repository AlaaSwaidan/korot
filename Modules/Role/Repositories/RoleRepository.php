<?php

namespace Modules\Role\Repositories;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleRepository
{
    public function index()
    {
        return Role::paginate(10);
    }

    public function store($request)
    {
        try {

            DB::beginTransaction();

            $data = $request->only('name');

            $role = Role::create($data);

            $role->syncPermissions($request['permissions']);

            DB::commit();
            return $role;
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.roles.index')->with('warning', 'Error , contact system');
        }


    }

    public function update($request, $role)
    {
        try {

            DB::beginTransaction();

            $data = $request->only('name');

            $role->update($data);

            $role->syncPermissions($request['permissions']);

            DB::commit();
            return $role;
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with(['message' => 'sorry please try again later', 'type' => 'error']);
        }
    }
    public function destroy($request)
    {
        try {
            $data = Role::find($request->id);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.roles.index')->with('warning', 'Error , contact system');
        }
    }
}
