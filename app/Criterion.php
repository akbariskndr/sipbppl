<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criterion extends Model
{
    protected $table = 'criteria';

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function getInstanceLevelNameAttribute()
    {
        return (['Kecil', 'Sedang', 'Besar'])[$this->instance_level - 1];
    }
    
    public function getComplexityLevelNameAttribute()
    {
        return (['Sangat Mudah', 'Mudah', 'Biasa', 'Rumit', 'Sangat Rumit'])[$this->complexity_level - 1];
    }
}
