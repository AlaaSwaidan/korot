<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountrySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('name',225)->nullable();
            $table->string('country_code')->nullable();
            $table->double('merchant_percentage')->nullable();
            $table->timestamps();
        });
        \App\Models\CountrySetting::create([
            'name'=>'suadi arabia',
            'country_code'=>'966',
            'merchant_percentage'=>1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country_settings');
    }
}
