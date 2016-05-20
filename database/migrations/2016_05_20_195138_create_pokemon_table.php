<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePokemonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pokemon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('display_name');
            $table->string('api_name');
            $table->text('sprite_normal_url');
            $table->text('sprite_shiny_url');
            $table->timestamps();
        });
    }//end up()

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pokemon');
    }//end down()
}//end class CreatePokemonTable
