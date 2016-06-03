<?php
namespace Poketracker\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @class
 * @summary
 * @author Jacob Stair
 */
class User extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Table columns which are not mass-assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Define one-to-many relationship.
     */
    public function userBredPokemon()
    {
        return $this->hasMany('Poketracker\Model\UserBredPokemon', 'user_id');
    }//end userBredPokemon()

    /**
     * Define one-to-many relationship.
     */
    public function caughtPokemon()
    {
        return $this->hasMany('Poketracker\Model\CaughtPokemon', 'user_id');
    }//end caughtPokemon()
}//end class User

//end file: User.php
