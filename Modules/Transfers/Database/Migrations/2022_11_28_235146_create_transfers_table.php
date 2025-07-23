<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->morphs('providerable')->nullable();
            $table->morphs('userable');
            $table->enum('type',['collection','transfer','indebtedness','restore','repayment','profits','payment','recharge']);
            $table->double('amount')->nullable();
            $table->double('transfers_total')->nullable();
            $table->double('collection_total')->nullable();
            $table->double('indebtedness')->nullable();
            $table->enum('transfer_type',['fawry','delay'])->nullable();
            $table->enum('collection_type',['bank','cash','check'])->nullable();
            $table->string('collection_description')->nullable();
            $table->boolean('confirm')->default(1);
            $table->softDeletes();


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
        Schema::dropIfExists('transfers');
    }
}
