<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWatchListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watch_list', function (Blueprint $table) {
            $table->id();
            $table->string('watchlist_title');
            $table->string('watchlist_cover');
            $table->string('cover_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_watch_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->unsignedBigInteger('anime_id');
            $table->foreign('anime_watch_id')->references('id')->on('animes')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('watch_list');
    }
}
