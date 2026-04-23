<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamHalaqah extends Model
{
    protected $guarded = [];

    public function jadwal_halaqah()
    {
        return $this->belongsToMany(JadwalHalaqah::class, 'jam_jadwal_halaqahs');
    }

     public function absen_halaqah()
    {
        return $this->hasMany(AbsenHalaqah::class);
    }
}
