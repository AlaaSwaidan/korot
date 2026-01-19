<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopupOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topup_orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('merchant_id');
            $table->string('phone');
            $table->string('country_code')->nullable();
            $table->string('sku_code')->nullable();
            $table->double('price')->nullable();
            $table->double('sell_price')->nullable();
            $table->double('receive_amount')->nullable();
            $table->double('merchant_percentage')->nullable();
            $table->double('merchant_profit')->nullable();
            $table->double('admin_profit')->nullable();


            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');


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
        Schema::dropIfExists('topup_orders');
    }
}
