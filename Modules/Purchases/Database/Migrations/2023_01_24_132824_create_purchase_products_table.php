<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_products', function (Blueprint $table) {
            $table->id();
           $table->unsignedBigInteger('purchase_order_id')->nullable();
           $table->string('product_id')->nullable();
           $table->integer('quantity')->nullable();
           $table->string('choose_tax')->nullable();
           $table->double('price')->nullable();
           $table->double('tax')->nullable();
           $table->double('total')->nullable();


            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('cascade');


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
        Schema::dropIfExists('purchase_products');
    }
}
