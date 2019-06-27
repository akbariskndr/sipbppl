<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    public function cost()
    {
        return $this->belongsTo('App\Cost');
    }
}
