<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionCountToSettingsTable extends Migration
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
            $table->bigInteger('transaction_count')->nullable()->after('bank_code');
            $table->bigInteger('transaction_days')->nullable()->after('bank_code');
        });
        \App\Models\Setting::find(1)->update([
            'transaction_count'=>100,
            'transaction_days'=>7,
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
