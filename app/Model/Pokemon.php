<?php
namespace Poketracker\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @class
 * @summary
 * @author Jacob Stair
 */
class Pokemon extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pokemon';

    /**
     * Table columns which are not mass-assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Define many-to-many relationship.
     */
    public function games()
    {
        return $this->belongsToMany('Poketracker\Model\Game', 'game_pokemon', 'pokemon_id', 'game_id');
    }//end games()

    /**
     * Define one-to-many relationship.
     */
    public function gamePokemon()
    {
        return $this->hasMany('Poketracker\Model\GamePokemon', 'pokemon_id');
    }//end gamePokemon()

    /**
     * Define one-to-many relationship.
     */
    public function userBredPokemon()
    {
        return $this->hasMany('Poketracker\Model\UserBredPokemon', 'pokemon_id');
    }//end userBredPokemon()
}//end class Pokemon

//end file: Pokemon.php
