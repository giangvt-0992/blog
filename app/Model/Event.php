<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $table = "events";
    
    public function action()
    {
        return $this->belongsTo('App\Model\Action');
    }
}
