<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionBanksTransfersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collection = collect([
            'Indebtedness_banks_transfers',
            'profits_banks_transfers',
            'balance_banks_transfers',

        ]);
        $collection->each(function ($item, $key) {
            $ids = [];
// create permissions for each collection item
            $p_view = Permission::create(['name' => 'view_' . $item, 'title' => 'View ' . $item, 'guard_name' => 'admin']);

            $p_create = Permission::create(['name' => 'accept_' . $item, 'title' => 'Create ' . $item, 'guard_name' => 'admin']);
            $p_repayment = Permission::create(['name' => 'refuse_' . $item, 'title' => 'Create ' . $item, 'guard_name' => 'admin']);


            $ids[] = $p_view->id;
            $ids[] = $p_create->id;
            $ids[] = $p_repayment->id;


            //create model
            $module = \App\Models\Module::create(['name' => $item, 'display_name' => 'module ' . $item]);

            $module->permissions()->attach($ids);
        });

        $owner_role = Role::firstOrCreate(['name' => 'super-admin'])->syncPermissions(Permission::all());

        $user = Admin::findOrFail(1);

        $user->syncRoles($owner_role)->syncPermissions(Permission::all());
    }
}
