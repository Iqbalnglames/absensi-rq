<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenMurid extends Model
{
    protected $table = 'absensi_murids';
    protected $guarded = [];

    public function murid()
    {
        return $this->belongsTo(Murid::class);
    }
    
    public function jadwal_pelajaran()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_mengajar_id');
    }
}
