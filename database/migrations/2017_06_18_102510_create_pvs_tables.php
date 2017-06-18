<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePvsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvs', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('session_id');
            $table->string('ip', 15)->nullable();
            $table->dateTime('visit_time');
            $table->text('user_agent')->nullable();
            $table->text('referer')->nullable();
            $table->text('request_uri');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pvs');
    }
}
