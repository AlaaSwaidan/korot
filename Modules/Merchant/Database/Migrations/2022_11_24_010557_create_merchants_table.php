<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->bigInteger('added_by')->nullable();
            $table->enum('added_by_type',['admin','distributor','site','app'])->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('image')->nullable();
            $table->string('tax_number')->nullable();
            $table->boolean('active')->default(false);
            $table->boolean('approve')->default(false)->nullable();
            $table->enum('type',['silver','golden','bronze'])->nullable();

            $table->string('password');
            $table->string('commercial_number')->nullable();
            $table->string('location',255)->nullable();
            $table->string('machine_number',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchants');
    }
}
