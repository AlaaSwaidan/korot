<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->bigInteger('updated_by')->unsigned();
            $table->string('name',225);
            $table->string('email');
            $table->string('phone');

            $table->longText('about')->nullable();
            $table->longText('terms')->nullable();

            $table->longText('bank_name')->nullable();
            $table->longText('bank_address')->nullable();
            $table->longText('account_number')->nullable();
            $table->longText('bank_code')->nullable();


            $table->foreign('updated_by')
                ->references('id')->on('admins')
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
        Schema::dropIfExists('settings');
    }
}
