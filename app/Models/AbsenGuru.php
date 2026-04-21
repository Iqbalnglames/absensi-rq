<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenGuru extends Model
{
    protected $guarded = [];

    public function jadwal_kerja()
    {
        return $this->belongsTo(JamKerja::class);
    }
}
