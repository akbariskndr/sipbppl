<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function costs()
    {
       return $this->hasMany('App\Cost');
    }
}
