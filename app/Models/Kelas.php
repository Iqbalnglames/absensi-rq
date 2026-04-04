<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $guarded = [];
    public function wali_kelas(){
        return $this->belongsTo(User::class, 'user_id');
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
    public function guruMapelKelas()
    {
        return $this->hasMany(GuruMapelKelas::class, 'kelas_id');
    }
    public function nilai(){
        return $this->hasMany(Nilai::class);
    }
}
