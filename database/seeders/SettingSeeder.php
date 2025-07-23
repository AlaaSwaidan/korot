<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'updated_by'                     => 1,
            'name'                          => ['ar'=>'كروت', 'en'=>"Korot"],
            'email'                          => 'info@korot.com',
            'phone'                          => '01027299053',
            'terms'                          =>['ar'=>'الشروط والأحكام', 'en'=>"Terms and Conditions"],
            'bank_name'     => ['ar'=>'كروت', 'en'=>"Korot Security"],
            'bank_address'     => ['ar'=>'القاهرة الحي الثامن', 'en'=>"block 8, New Cairo"],
            'account_number'=>"87694387604385730",
            'bank_code'=>"87453486",
        ]);
    }
}
