<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenTahfidz extends Model
{
    public function jam_halaqah()
    {
        return $this->belongsTo(JamHalaqah::class);
    }

    public function murid()
    {
        return $this->belongsTo(Murid::class);
    }
}
