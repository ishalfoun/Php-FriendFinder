<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;


    protected $fillable = [
        'name', 'email', 'program', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The courses that belong to the user.
     */
    public function courses()
    {
        return $this->belongsToMany('App\Course');
    }

    public function friends()
    {
        return $this->belongsToMany('App\User', 'friendships', 'friend1_id', 'friend2_id');
    }

}
