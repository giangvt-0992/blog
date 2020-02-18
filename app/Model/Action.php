<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table = "actions";
    protected $fillable = ['type', 'actionable_type', 'actionable_id', 'content'];

    public function actionable()
    {
        return $this->morphTo();
    }

    public function event(){
        return $this->hasOne('App\Model\Event');
    }

}
