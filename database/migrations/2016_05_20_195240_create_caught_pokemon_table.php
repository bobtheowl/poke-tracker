<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaughtPokemonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caught_pokemon', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_pokemon_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('is_shiny');
            $table->boolean('has_pokerus');
            $table->timestamps();

            $table->foreign('game_pokemon_id')
                ->references('id')->on('game_pokemon')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')->on('users')
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
        Schema::dropForeign('caught_pokemon_game_pokemon_id_foreign');
        Schema::dropForeign('caught_pokemon_user_id_foreign');
        Schema::drop('caught_pokemon');
    }//end down()
}//end class CreateCaughtPokemonTable
