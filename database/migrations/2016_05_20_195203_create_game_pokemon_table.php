<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamePokemonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_pokemon', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id')->unsigned();
            $table->integer('pokemon_id')->unsigned();
            $table->timestamps();

            $table->foreign('game_id')
                ->references('id')->on('games')
                ->onDelete('cascade');
            $table->foreign('pokemon_id')
                ->references('id')->on('pokemon')
                ->onDelete('cascade');
        });
    }//end up()

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropForeign('game_pokemon_game_id_foreign');
        Schema::dropForeign('game_pokemon_pokemon_id_foreign');
        Schema::drop('game_pokemon');
    }//end down()
}//end class CreateGamePokemonTable
