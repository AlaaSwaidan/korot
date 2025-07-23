<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewTypesToMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchants', function (Blueprint $table) {
            //
            DB::statement("
                ALTER TABLE `merchants`
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
        Schema::table('merchants', function (Blueprint $table) {
            //
        });
    }
}
