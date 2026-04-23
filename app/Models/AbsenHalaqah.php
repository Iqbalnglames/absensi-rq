<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenHalaqah extends Model
{
    public function murid()
    {
        return $this->belongsTo(Murid::class);
    }

    public function jam_halaqah()
    {
        return $this->belongsTo(JamHalaqah::class);
    }
}
