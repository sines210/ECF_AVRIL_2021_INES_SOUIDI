<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWLTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_l', function (Blueprint $table) {
            $table->id();
            $table->string('w_title');
            $table->string('w_cover');
            $table->string('cov_id')->unique();
            $table->unsignedBigInteger('user_w_id');
            $table->foreign('user_w_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->unsignedBigInteger('anime_w_id');
            $table->foreign('anime_w_id')->references('id')->on('animes')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('w_l');
    }
}
