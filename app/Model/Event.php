<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $table = "events";
    protected $fillable = ['creator_id', 'owner_id', 'action_id'];
    public function action()
    {
        return $this->belongsTo('App\Model\Action');
    }

    public function eventable(){
        return $this->morphTo();
    }

    public function owner()
    {
        // a event attemp to an user
        return $this->belongsTo('App\Model\User', 'owner_id', 'id');
    }
    
    public function creator()
    {
        // a event belong to an user
        return $this->belongsTo('App\Model\User', 'creator_id', 'id');
    }

    
}
