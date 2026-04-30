<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalTahfidz extends Model
{
    protected $guarded = [];
    public function jam_halaqah()
    {
        return $this->belongsTo(JamHalaqah::class);
    }

    public function absen_halaqah()
    {
        return $this->hasMany(AbsenHalaqah::class);
    }
}
