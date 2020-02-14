<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = 'posts';
    protected $fillable = ['title', 'content', 'status', 'user_id'];
    protected $guarded = ['id'];

    public function comments()
    {
        return $this->hasMany('App\Comment', 'post_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
