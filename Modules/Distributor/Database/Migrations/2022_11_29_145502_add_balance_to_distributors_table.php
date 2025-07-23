<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBalanceToDistributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distributors', function (Blueprint $table) {
            $table->double('balance')->default(false)->nullable()->after('active');
            $table->double('collection_total')->default(false)->nullable()->after('active');
            $table->double('transfer_total')->default(false)->nullable()->after('active');
            $table->double('indebtedness')->default(false)->nullable()->after('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distributors', function (Blueprint $table) {

        });
    }
}
