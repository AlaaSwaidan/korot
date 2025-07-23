<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->double('total_sales')->default(false);
            $table->double('api_sales')->default(false);
            $table->double('not_api_sales')->default(false);
            $table->double('total_card_sold')->default(false);
            $table->double('api_card_sold')->default(false);
            $table->double('not_api_card_sold')->default(false);
            $table->double('total_cost')->default(false);
            $table->double('api_card_cost')->default(false);
            $table->double('not_api_card_cost')->default(false);
            $table->double('total_profits')->default(false);
            $table->double('api_card_profits')->default(false);
            $table->double('not_api_card_profits')->default(false);
            $table->double('card_numbers')->default(false);
            $table->double('distributors_balance')->default(false);
            $table->double('merchants_balance')->default(false);
            $table->double('admins_balance')->default(false);
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
        Schema::dropIfExists('statistics');
    }
}
