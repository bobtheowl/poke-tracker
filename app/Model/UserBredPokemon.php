<?php
namespace Poketracker\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @class
 * @summary
 * @author Jacob Stair
 */
class UserBredPokemon extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_bred_pokemon';

    /**
     * Table columns which are not mass-assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

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
    public function gender()
    {
        return $this->belongsTo('Poketracker\Model\Gender', 'gender_id');
    }//end gender()

    /**
     * Define one-to-many relationship.
     */
    public function user()
    {
        return $this->belongsTo('Poketracker\Model\User', 'user_id');
    }//end user()
}//end class UserBredPokemon

//end file: UserBredPokemon.php
