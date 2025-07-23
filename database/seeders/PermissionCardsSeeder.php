<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionCardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collection = collect([
            'cards',
        ]);
        $collection->each(function ($item, $key) {
            $ids = [];
// create permissions for each collection item
            $p_view = Permission::create(['name' => 'sold_' . $item, 'title' => 'sold ' . $item, 'guard_name' => 'admin']);

            $p_create = Permission::create(['name' => 'mostSeller_' . $item, 'title' => 'mostSeller ' . $item, 'guard_name' => 'admin']);

            $p_update = Permission::create(['name' => 'lessSeller_' . $item, 'title' => 'lessSelle ' . $item, 'guard_name' => 'admin']);




            $ids[] = $p_view->id;
            $ids[] = $p_create->id;
            $ids[] = $p_update->id;


            //create model
            $module = \App\Models\Module::find(9);

            $module->permissions()->attach($ids);
        });

        $owner_role = Role::firstOrCreate(['name' => 'super-admin'])->syncPermissions(Permission::all());

        $user = Admin::findOrFail(1);

        $user->syncRoles($owner_role)->syncPermissions(Permission::all());
    }
}
