<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenEkskul extends Model
{
    protected $guarded = [];

    public function murid()
    {
        return $this->belongsTo(Murid::class);
    }
    
    public function jadwal_pelajaran()
    {
        return $this->belongsTo(JadwalEkskul::class);
    }
}
