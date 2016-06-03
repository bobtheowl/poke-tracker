<?php
namespace Poketracker\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @class
 * @summary
 * @author Jacob Stair
 */
class CaughtPokemon extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'caught_pokemon';

    /**
     * Table columns which are not mass-assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Define many-to-many relationship.
     */
    public function gamePokemon()
    {
        return $this->belongsTo('Poketracker\Model\GamePokemon', 'game_pokemon_id');
    }//end gamePokemon()

    /**
     * Define one-to-many relationship.
     */
    public function user()
    {
        return $this->belongsTo('Poketracker\Model\User', 'user_id');
    }//end user()
}//end class CaughtPokemon

//end file: CaughtPokemon.php
