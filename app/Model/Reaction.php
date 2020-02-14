<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    //
    protected $table = "reactions";

    public function reactionable()
    {
        return $this->morphTo();
    }

    public function user(){
        // a reaction belong to an user
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }
}
