<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $guarded = []; 
    
    public function guru_mapel(){
        return $this->belongsToMany(Jadwal::class, 'mapel_gurus');
    }

    public function jadwal(){
        return $this->hasMany(Jadwal::class);
    }
    public function nilai(){
        return $this->hasMany(Nilai::class);
    }
}
