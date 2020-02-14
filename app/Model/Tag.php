<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $table = "tags";

    public function posts()
    {
        return $this->morphedByMany('App\Model\Post', 'taggable');
    }

    public function tickets()
    {
        # code...
        return $this->morphedByMany('App\Model\Ticket', 'taggable');
    }
}
