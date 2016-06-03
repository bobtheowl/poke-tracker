<?php
namespace Poketracker\Model;

/**
 * @class
 * @summary
 * @author Jacob Stair
 */
class GamePokemon extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'game_pokemon';

    /**
     * Table columns which are not mass-assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Define one-to-many relationship.
     */
    public function game()
    {
        return $this->belongsTo('Poketracker\Model\Game', 'game_id');
    }//end game()

    /**
     * Define one-to-many relationship.
     */
    public function pokemon()
    {
        return $this->belongsTo('Poketracker\Model\Pokemon', 'pokemon_id');
    }//end pokemon()

    /**
     * Define one-to-many relationship.
     */
    public function caughtPokemon()
    {
        return $this->hasMany('Poketracker\Model\CaughtPokemon', 'game_pokemon_id');
    }//end caughtPokemon()
}//end class GamePokemon

//end file: GamePokemon.php
