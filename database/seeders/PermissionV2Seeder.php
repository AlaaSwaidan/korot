<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionV2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collection = collect([
            'roles',
            'distributors',
            'merchants',
        ]);
        $collection->each(function ($item, $key) {
            $ids = [];
// create permissions for each collection item
            $p_view = Permission::create(['name' => 'view_' . $item, 'title' => 'View ' . $item, 'guard_name' => 'admin']);

            $p_create = Permission::create(['name' => 'create_' . $item, 'title' => 'Create ' . $item, 'guard_name' => 'admin']);

            $p_update = Permission::create(['name' => 'update_' . $item, 'title' => 'Update ' . $item, 'guard_name' => 'admin']);

            $p_delete = Permission::create(['name' => 'delete_' . $item, 'title' => 'Delete ' . $item, 'guard_name' => 'admin']);

            if ($item == "merchants"){

                $p_waiting = Permission::create(['name' => 'waitingView_' . $item, 'title' => 'waitingView ' . $item, 'guard_name' => 'admin']);
                $p_approve = Permission::create(['name' => 'waitingApprove_' . $item, 'title' => 'waitingApprove ' . $item, 'guard_name' => 'admin']);
                $p_delete = Permission::create(['name' => 'waitingDelete_' . $item, 'title' => 'waitingDelete ' . $item, 'guard_name' => 'admin']);
                $p_Waitingshow = Permission::create(['name' => 'waitingShow_' . $item, 'title' => 'waitingShow ' . $item, 'guard_name' => 'admin']);
                $p_show = Permission::create(['name' => 'show_' . $item, 'title' => 'show ' . $item, 'guard_name' => 'admin']);
                $p_prices = Permission::create(['name' => 'prices_' . $item, 'title' => 'prices ' . $item, 'guard_name' => 'admin']);
                $p_changePass = Permission::create(['name' => 'changePass_' . $item, 'title' => 'changePass ' . $item, 'guard_name' => 'admin']);
                $ids[] = $p_waiting->id;
                $ids[] = $p_approve->id;
                $ids[] = $p_delete->id;
                $ids[] = $p_Waitingshow->id;
                $ids[] = $p_show->id;
                $ids[] = $p_prices->id;
                $ids[] = $p_changePass->id;
            }
            if ($item == "distributors"){

                $p_show = Permission::create(['name' => 'show_' . $item, 'title' => 'show ' . $item, 'guard_name' => 'admin']);
                $p_changePass = Permission::create(['name' => 'changePass_' . $item, 'title' => 'changePass ' . $item, 'guard_name' => 'admin']);
                $ids[] = $p_show->id;
                $ids[] = $p_changePass->id;
            }

            $ids[] = $p_view->id;
            $ids[] = $p_create->id;
            $ids[] = $p_update->id;
            $ids[] = $p_delete->id;


            //create model
            $module = \App\Models\Module::create(['name' => $item, 'display_name' => 'module ' . $item]);

            $module->permissions()->attach($ids);
        });

        $owner_role = Role::firstOrCreate(['name' => 'super-admin'])->syncPermissions(Permission::all());

        $user = Admin::findOrFail(1);

        $user->syncRoles($owner_role)->syncPermissions(Permission::all());
    }
}
