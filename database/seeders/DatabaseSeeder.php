<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
//        $this->call(AddCardSeeder::class);
//        $this->call(CountrySeeder::class);
//        $this->call(CitySeeder::class);
//        $this->call(SuperAdminSeeder::class);
//        $this->call(SuperRoleSeeder::class);
//        $this->call(SettingSeeder::class);
//        $this->call(StatisticSeeder::class);
//        $this->call(PermissionsV1Seeder::class);
//        $this->call(PermissionV2Seeder::class);
//        $this->call(PermissionStoresSeeder::class);
//        $this->call(PermissionCardsSeeder::class);
//        $this->call(PermissionTransfersSeeder::class);
//        $this->call(PermissionRepaymentSeeder::class);
//        $this->call(PermissionBanksTransfersSeeder::class);
//        $this->call(PermissionProcessSeeder::class);
//        $this->call(PermissionNotificationsSeeder::class);
//        $this->call(PermissionSettingsSeeder::class);
//        $this->call(PermissionCurrenciesSeeder::class);
//        $this->call(PermissionbanksSeeder::class);
//        $this->call(PermissionJournalsSeeder::class);
//        $this->call(PermissionOutgoingsSeeder::class);
//        $this->call(PermissionSuppliersSeeder::class);
//        $this->call(PermissionpurchaseOrdersSeeder::class);
//        $this->call(AllReportSeeder::class);
//        $this->call(PermissionSideMenuSeeder::class);
//        $this->call(DuplicateOrderSeeder::class);
        $this->call(PermissionDepartmentsSeeder::class);
    }
}
