<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{

    protected $table = 'jadwal_mengajars';

    protected $guarded = []; 
    
    public function jurnals()
    {
        return $this->hasMany(Jurnal::class);
    }
    public function jam_pelajaran()
    {
        return $this->belongsToMany(JamPelajaran::class, 'jam_mapels');
    }

    public function absens()
    {
        return $this->hasMany(AbsenMurid::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}