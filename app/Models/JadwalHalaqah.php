<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalHalaqah extends Model
{
    protected $guarded = [];

    public function jam_halaqah()
    {
        return $this->belongsToMany(JamHalaqah::class, 'jam_jadwal_halaqahs');
    }

    public function halaqah()
    {
        return $this->belongsTo(Halaqah::class);
    }
}
