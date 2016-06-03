<?php
namespace Poketracker\Model;

/**
 * @class
 * @summary
 * @author Jacob Stair
 */
class Gender extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'genders';

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
        return $this->hasMany('Poketracker\Model\UserBredPokemon', 'gender_id');
    }//end userBredPokemon()
}//end class Gender

//end file: Gender.php
