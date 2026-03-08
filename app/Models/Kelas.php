<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function jenjang(){
        return $this->belongsTo(Jenjang::class);
    }
    public function jadwal(){
        return $this->hasMany(Jadwal::class);
    }
    public function murid(){
        return $this->hasMany(Murid::class);
    }
    public function nilai(){
        return $this->hasMany(Nilai::class);
    }
}
