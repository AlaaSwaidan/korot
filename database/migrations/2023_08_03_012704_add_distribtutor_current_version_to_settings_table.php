<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDistribtutorCurrentVersionToSettingsTable extends Migration
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
            $table->string('distributor_current_version')->nullable()->after('version_date');
            $table->boolean('distributor_version_status')->default(false)->after('version_date');
            $table->date('distributor_version_date')->nullable()->after('version_date');
            $table->string('distributor_version_apk_link',255)->nullable()->after('version_date');

        });
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
