<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewTypesToPackagePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_prices', function (Blueprint $table) {
            //
            DB::statement("
                ALTER TABLE `package_prices`
                MODIFY COLUMN `type`
                ENUM('silver','golden','bronze','platinum','bronzz','diamond','pearl','emerald','ruby','crystal')
                NULL DEFAULT NULL
            ");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_prices', function (Blueprint $table) {
            //
        });
    }
}
