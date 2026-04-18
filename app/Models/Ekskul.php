<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ekskul extends Model
{
    protected $guarded = [];

    public function murid()
    {
        return $this->belongsToMany(Murid::class, 'ekskul_murids');
    }

    public function jadwal_ekskul()
    {
        return $this->hasMany(JadwalEkskul::class);
    }
}
