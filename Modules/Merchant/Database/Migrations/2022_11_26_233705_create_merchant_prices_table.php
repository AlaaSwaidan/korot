<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_prices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->bigInteger('added_by')->unsigned()->nullable();
            $table->bigInteger('merchant_id')->unsigned()->nullable();
            $table->bigInteger('package_id')->unsigned()->nullable();
            $table->double('old_price')->nullable();
            $table->double('price')->nullable();
            $table->enum('type',['silver','golden','bronze'])->nullable();



            $table->foreign('added_by')
                ->references('id')->on('admins')
                ->onDelete('cascade');
            $table->foreign('merchant_id')
                ->references('id')->on('merchants')
                ->onDelete('cascade');
            $table->foreign('package_id')
                ->references('id')->on('packages')
                ->onDelete('cascade');
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
        Schema::dropIfExists('merchant_prices');
    }
}
