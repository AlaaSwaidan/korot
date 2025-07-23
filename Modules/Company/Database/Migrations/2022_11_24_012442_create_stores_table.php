<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->bigInteger('parent_id')->unsigned()->nullable();


            $table->text('name');
            $table->string('image')->nullable();
            $table->boolean('api_linked')->default(false);
            $table->bigInteger('arrangement')->nullable();
            $table->text('description')->nullable();


            $table->foreign('parent_id')
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
        Schema::dropIfExists('stores');
    }
}
