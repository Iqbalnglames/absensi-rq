<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalEkskul extends Model
{
    protected $guarded = [];
    
    public function jurnal_ekskul()
    {
        return $this->hasMany(JurnalEkskul::class);
    }

    public function absen_ekskul()
    {
        return $this->hasMany(AbsenEkskul::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class);
    }
}
