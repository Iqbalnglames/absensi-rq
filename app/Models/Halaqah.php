<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Halaqah extends Model
{
    protected $guarded = [];

    public function jadwal_halaqah()
    {
        return $this->hasMany(JadwalHalaqah::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function murid()
    {
        return $this->hasMany(Murid::class);
    }
}
