<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $table = 'comments';
    protected $guarded = ['id'];
    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }

    public function commentable(){
        // a comment can be long to a ticket or a post
        return $this->morphMany('App\Model\Comment', 'commentable');
    }

    public function reaction(){
        // a comment has a morph reaction
        return $this->morphOne('App\Model\Reaction', 'reactionable');
    }

    public function action(){
        // a comment has a morph action
        return $this->morphOne('App\Model\Action', 'actionable');
    }

    public function events()
    {
        return $this->morphMany('App\Model\Event', 'eventable');
    }
}
