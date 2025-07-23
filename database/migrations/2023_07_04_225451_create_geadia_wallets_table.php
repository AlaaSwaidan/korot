<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeadiaWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geadia_wallets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            //       'user_id',
            //        'balance',
            //        'type',
            //        'transfer_id'
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('transfer_id')->nullable();
            $table->double('balance');
            $table->string('transaction_id');
            $table->enum('type',['charge','order']);

            $table->foreign('user_id')
                ->references('id')->on('merchants')->onDelete('cascade');

            $table->foreign('transfer_id')
                ->references('id')->on('transfers')->onDelete('cascade');

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
        Schema::dropIfExists('geadia_wallets');
    }
}
