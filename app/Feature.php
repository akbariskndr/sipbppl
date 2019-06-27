<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function getPriorityNameAttribute()
    {
        return (['Diperlukan', 'Penting', 'Opsional', 'Tidak Penting', 'Tidak Diperlukan'])[$this->priority - 1];
    }
}