<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->bigInteger('store_id')->unsigned()->nullable();
            $table->text('name');
            $table->boolean('status')->nullable();
            $table->double('card_price')->nullable();
            $table->double('cost')->nullable();
            $table->bigInteger('arrangement')->nullable();
            $table->string('gencode',225)->nullable();




            $table->foreign('store_id')
                ->references('id')->on('stores')
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
        Schema::dropIfExists('packages');
    }
}
