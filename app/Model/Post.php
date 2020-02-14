<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = 'posts';
    protected $fillable = ['title', 'content', 'status', 'user_id'];
    protected $guarded = ['id'];

    public function comments()
    {
        return $this->morphMany('App\Model\Comment', 'commentable');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

    public function tags()
    {
        return $this->morphToMany('App\Model\Tag', 'taggable');
    }
}
