<?php
namespace Poketracker\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @class
 * @summary
 * @author Jacob Stair
 */
class Game extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'games';

    /**
     * Table columns which are not mass-assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Define one-to-many relationship.
     */
    public function gamePokemon()
    {
        return $this->hasMany('Poketracker\Model\GamePokemon');
    }//end gamePokemon()

    /**
     * Define many-to-many relationship.
     */
    public function pokemon()
    {
        return $this->belongsToMany('Poketracker\Model\Pokemon', 'game_pokemon', 'game_id', 'pokemon_id');
    }//end pokemon()
}//end class Game

//end file: Game.php
