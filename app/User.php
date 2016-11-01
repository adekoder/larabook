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
    protected $fillable = [
        'firstname', 'lastname','email', 'password', 'date_of_birth','gender', 'active','nationality','bio'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profileImage()
    {
        return $this->hasOne('App\profileImage');
    }

    public function posts()
    {
        return $this->hasMany("App\Posts"  , "user_id");
    }

    
}
