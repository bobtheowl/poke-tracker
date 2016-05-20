<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBredPokemonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bred_pokemon', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pokemon_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('gender_id')->unsigned();
            $table->boolean('has_perfect_hp');
            $table->boolean('has_perfect_atk');
            $table->boolean('has_perfect_def');
            $table->boolean('has_perfect_spatk');
            $table->boolean('has_perfect_spdef');
            $table->boolean('has_perfect_speed');
            $table->boolean('is_foreign');
            $table->timestamps();

            $table->foreign('pokemon_id')
                ->references('id')->on('pokemon')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('gender_id')
                ->references('id')->on('genders')
                ->onDelete('restrict');
        });
    }//end up()

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropForeign('user_bred_pokemon_pokemon_id_foreign');
        Schema::dropForeign('user_bred_pokemon_user_id_foreign');
        Schema::dropForeign('user_bred_pokemon_gender_id_foreign');
        Schema::drop('user_bred_pokemon');
    }//end down()
}//end class CreateUserBredPokemonTable
