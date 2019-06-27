<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'name', 'email', 'password',
    ];

    public $timestamps = true;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function projects()
    {
       return $this->hasMany('App\Project');
    }

    public function weights()
    {
       return $this->hasMany('App\Weight');
    }

    public function getAccessNameAttribute()
    {
        return (['Admin', 'Operator', 'Manajer'])[$this->access - 1];
    }
}
