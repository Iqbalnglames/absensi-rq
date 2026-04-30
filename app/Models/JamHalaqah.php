<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamHalaqah extends Model
{
    protected $guarded = [];

    public function absen_halaqah()
    {
        return $this->hasMany(AbsenHalaqah::class);
    }

    public function halaqah()
    {
        return $this->belongsToMany(Halaqah::class, 'jam_halaqah_harians');
    }

    public function jurnal_halaqah()
    {
        return $this->hasMany(JurnalTahfidz::class, 'jurnal_tahfidzs');
    }
}
