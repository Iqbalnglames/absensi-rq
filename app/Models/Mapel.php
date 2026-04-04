<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $guarded = [];

    public function guruMapelKelas()
    {
        return $this->hasMany(GuruMapelKelas::class, 'mapel_id');
    }

    public function jadwal(){
        return $this->hasMany(Jadwal::class);
    }
    public function nilai(){
        return $this->hasMany(Nilai::class);
    }
}
