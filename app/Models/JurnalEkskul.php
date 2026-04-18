<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalEkskul extends Model
{
    protected $guarded = [];

    public function jadwal_ekskul()
    {
        return $this->belongsTo(JadwalEkskul::class);
    }
}
