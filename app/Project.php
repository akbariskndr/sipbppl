<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function criterion()
    {
        return $this->hasOne('App\Criterion');
    }

    public function features()
    {
        return $this->hasMany('App\Feature');
    }

    public function cost()
    {
        return $this->hasOne('App\Cost');
    }

    public function getPaymentStatusNameAttribute()
    {
        return (['Belum Dihitung', 'Belum Dibayar', 'Dibayar Sebagian', 'Lunas'])[$this->payment_status - 1];
    }

    public function getProjectStatusNameAttribute()
    {
        return (['Gagal', 'Pending', 'Sedang Dikerjakan', 'Selesai'])[$this->project_status - 1];
    }

    public function getPaymentTypeNameAttribute()
    {
        return (['Parsial', 'Bayar Penuh'])[$this->payment_type - 1];
    }
}
