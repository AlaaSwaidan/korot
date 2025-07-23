<?php

namespace Modules\Admin\Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AdminsSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Admin::create([
            'name'      => 'Super Admin',
            'email'     => 'admin@email.com',
            'phone'     => '01027299053',
            'password'  => '123456',
            'type'  => 'super_admin',
        ]);
    }
}
