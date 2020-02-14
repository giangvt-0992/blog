<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany('App\Model\Post', 'user_id');
    }
    public function comments()
    {
        return $this->hasMany('App\Model\Comment', 'user_id');
    }

    public function tickets(){
        // an user has many ticket
        return $this->hasMany('App\Model\Ticket', 'user_id');
    }

    public function reactions()
    {
        // an user has manyi reaction
        return $this->hasMany('App\Model\Reaction', 'user_id');
        # code...
    }
    
    public function event_creators()
    {
        // an user has manyi reaction
        return $this->hasMany('App\Model\Event', 'creator_id');
        # code...
    }

    public function event_owners()
    {
        // an user has manyi reaction
        return $this->hasMany('App\Model\Event', 'owner_id');
        # code...
    }

    public function role(){
        // an user belong to a role
        return $this->belongsTo('App\Model\Role');
    }
}
