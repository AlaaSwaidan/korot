<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStreetToMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchants', function (Blueprint $table) {
            // 'street',
            //    'distinct',
            //    'zipcode',
            //    'building_number',
            //    'extra_number',
            //    'city_id',
            //    'region_id',
            $table->string('street')->nullable()->after('location');
            $table->string('distinct')->nullable()->after('location');
            $table->string('zipcode')->nullable()->after('location');
            $table->string('building_number')->nullable()->after('location');
            $table->string('extra_number')->nullable()->after('location');
            $table->string('region_id')->nullable()->after('location');
            $table->unsignedBigInteger('city_id')->nullable();


            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');

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
