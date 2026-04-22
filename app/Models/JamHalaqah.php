<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamHalaqah extends Model
{
    protected $guarded = []; 

    public function halaqah()
    {
        return $this->belongsTo(Halaqah::class);
    }

    public function absen_tahfidz()
    {
        return $this->hasMany(AbsenTahfidz::class);
    }
}
