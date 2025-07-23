<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionpurchaseOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    //purchase-orders
    public function run()
    {
        $collection = collect([
            'purchase_orders',
            'invoices',
        ]);
        $collection->each(function ($item, $key) {
            $ids = [];
// create permissions for each collection item
            if ($item == "invoices"){
                $p_view = Permission::create(['name' => 'view_' . $item, 'title' => 'View ' . $item, 'guard_name' => 'admin']);
                $ids[] = $p_view->id;
            }else{
                $p_view = Permission::create(['name' => 'view_' . $item, 'title' => 'View ' . $item, 'guard_name' => 'admin']);

                $p_create = Permission::create(['name' => 'create_' . $item, 'title' => 'Create ' . $item, 'guard_name' => 'admin']);

                $p_update = Permission::create(['name' => 'update_' . $item, 'title' => 'Update ' . $item, 'guard_name' => 'admin']);

                $p_delete = Permission::create(['name' => 'delete_' . $item, 'title' => 'Delete ' . $item, 'guard_name' => 'admin']);

                $p_show = Permission::create(['name' => 'show_' . $item, 'title' => 'Delete ' . $item, 'guard_name' => 'admin']);
                $p_accept = Permission::create(['name' => 'accept_' . $item, 'title' => 'Delete ' . $item, 'guard_name' => 'admin']);
                $ids[] = $p_view->id;
                $ids[] = $p_create->id;
                $ids[] = $p_update->id;
                $ids[] = $p_delete->id;
                $ids[] = $p_show->id;
                $ids[] = $p_accept->id;

            }






            //create model
            $module = \App\Models\Module::create(['name' => $item, 'display_name' => 'module ' . $item]);

            $module->permissions()->attach($ids);
        });

        $owner_role = Role::firstOrCreate(['name' => 'super-admin'])->syncPermissions(Permission::all());

        $user = Admin::findOrFail(1);

        $user->syncRoles($owner_role)->syncPermissions(Permission::all());
    }
}
