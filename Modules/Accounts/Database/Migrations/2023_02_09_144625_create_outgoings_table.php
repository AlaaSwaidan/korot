<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutgoingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outgoings', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->nullable();
            $table->double('discount')->nullable();
            $table->date('date');
            $table->string('company_name',255);
            $table->string('tax_number')->nullable();
            $table->double('tax');
            $table->double('amount');
            $table->double('total');
            $table->double('quantity');
            $table->string('notes')->nullable();
            $table->string('payment_method')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');
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
        Schema::dropIfExists('outgoings');
    }
}
