<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionLowestCountToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->bigInteger('transaction_lowest_count')->nullable()->after('transaction_count');
            $table->bigInteger('transaction_lowest_day')->nullable()->after('transaction_count');
        });
        \App\Models\Setting::find(1)->update([
            'transaction_lowest_count'=>20,
            'transaction_lowest_day'=>7,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
}
