<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    protected $table = "tickets";
    protected $fillable = ['title', 'content', 'status', 'user_id'];
    protected $guarded = ['id'];
    
    public function comments()
    {
        return $this->morphMany('App\Model\Comment', 'commentable');
    }

    public function user(){
        // a ticket belong to an user
        return $this->belongsTo('App\Model\User');
    }

    public function reaction(){
        // a ticket has a morph reaction
        return $this->morphOne('App\Model\Reaction', 'reactionable');
    }

    public function tags(){
        return $this->morphToMany('App\Model\Tag', 'taggable');
    }
}
