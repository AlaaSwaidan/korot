<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBalanceToMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchants', function (Blueprint $table) {
            $table->double('balance')->default(false)->nullable()->after('machine_number');
            $table->double('collection_total')->default(false)->nullable()->after('machine_number');
            $table->double('transfer_total')->default(false)->nullable()->after('machine_number');
            $table->double('indebtedness')->default(false)->nullable()->after('machine_number');
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

        });
    }
}
