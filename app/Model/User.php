<?php
namespace Poketracker\Model;

/**
 * @class
 * @summary 
 * @author Jacob Stair
 */
class User extends Eloquent
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
}//end class User

//end file: User.php
