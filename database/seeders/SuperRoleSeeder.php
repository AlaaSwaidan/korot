<?php

namespace Database\Seeders;

use App\Models\Admin;

use Illuminate\Database\Seeder;

class SuperRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_role = \Spatie\Permission\Models\Role::create([
            'name' => 'super-admin',
            'guard_name' => 'admin'
        ]);


        $admins = Admin::whereType('super_admin')->get();
        foreach ($admins as $admin) {
            $admin->syncRoles($super_role);
        }

    }
}
