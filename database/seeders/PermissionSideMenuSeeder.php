<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSideMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collection = collect([
            'side_menu',
        ]);
        $collection->each(function ($item, $key) {
            $ids = [];
// create permissions for each collection item
            $p_view = Permission::create(['name' => 'viewPermission_' . $item, 'title' => 'view Permission ' . $item, 'guard_name' => 'admin']);

            $p_create = Permission::create(['name' => 'viewUsers_' . $item, 'title' => 'view Users ' . $item, 'guard_name' => 'admin']);

            $p_update = Permission::create(['name' => 'viewStores_' . $item, 'title' => 'viewStores ' . $item, 'guard_name' => 'admin']);
            $p_reports = Permission::create(['name' => 'viewReports_' . $item, 'title' => 'viewReports ' . $item, 'guard_name' => 'admin']);
            $p_transfers = Permission::create(['name' => 'viewTransfers_' . $item, 'title' => 'ViewCollection ' . $item, 'guard_name' => 'admin']);
            $p_collections = Permission::create(['name' => 'viewCollections_' . $item, 'title' => 'viewCollections ' . $item, 'guard_name' => 'admin']);
            $p_repayments = Permission::create(['name' => 'viewRepayments_' . $item, 'title' => 'viewRepayments ' . $item, 'guard_name' => 'admin']);
            $p_orders = Permission::create(['name' => 'viewWaitingOrders_' . $item, 'title' => 'viewWaitingOrders ' . $item, 'guard_name' => 'admin']);
            $p_process = Permission::create(['name' => 'viewProcesses_' . $item, 'title' => 'viewProcesses ' . $item, 'guard_name' => 'admin']);
            $p_notifications = Permission::create(['name' => 'viewNotifications_' . $item, 'title' => 'viewNotifications ' . $item, 'guard_name' => 'admin']);
            $p_settings = Permission::create(['name' => 'viewSettings_' . $item, 'title' => 'viewSettings ' . $item, 'guard_name' => 'admin']);
            $p_accounts = Permission::create(['name' => 'viewAccounts_' . $item, 'title' => 'viewAccounts ' . $item, 'guard_name' => 'admin']);
            $p_outgoings = Permission::create(['name' => 'viewOutgoings_' . $item, 'title' => 'viewOutgoings ' . $item, 'guard_name' => 'admin']);
            $p_purchases = Permission::create(['name' => 'viewPurchases_' . $item, 'title' => 'viewPurchases ' . $item, 'guard_name' => 'admin']);




            $ids[] = $p_view->id;
            $ids[] = $p_create->id;
            $ids[] = $p_update->id;
            $ids[] = $p_reports->id;
            $ids[] = $p_transfers->id;
            $ids[] = $p_collections->id;
            $ids[] = $p_repayments->id;
            $ids[] = $p_orders->id;
            $ids[] = $p_process->id;
            $ids[] = $p_notifications->id;
            $ids[] = $p_settings->id;
            $ids[] = $p_accounts->id;
            $ids[] = $p_outgoings->id;
            $ids[] = $p_purchases->id;


            //create model
            $module = \App\Models\Module::create(['name' => $item, 'display_name' => 'module ' . $item]);

            $module->permissions()->attach($ids);
        });

        $owner_role = Role::firstOrCreate(['name' => 'super-admin'])->syncPermissions(Permission::all());

        $user = Admin::findOrFail(1);

        $user->syncRoles($owner_role)->syncPermissions(Permission::all());
    }
}
