<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->bigInteger('merchant_id')->unsigned()->nullable();
            $table->string('name',255)->nullable();
            $table->string('card_number')->nullable();
            $table->string('serial_number')->nullable();
            $table->double('cost')->nullable();
            $table->integer('count')->nullable();
            $table->double('card_price')->nullable();
            $table->double('merchant_price')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('status')->nullable();
            $table->foreign('merchant_id')
                ->references('id')->on('merchants')
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
        Schema::dropIfExists('orders');
    }
}
