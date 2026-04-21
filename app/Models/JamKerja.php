<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamKerja extends Model
{
    protected $table = 'jadwal_kerjas';

    protected $guarded = ['id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function absen_guru()
    {
        return $this->hasMany(AbsenGuru::class);
    }
}
