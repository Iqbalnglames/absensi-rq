<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    protected $guarded = []; 
    
    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }
    public function nilai(){
        return $this->hasMany(Nilai::class);
    }
    public function halaqah(){
        return $this->belongsTo(Halaqah::class);
    }
    public function mutabaah(){
        return $this->hasMany(Mutabaah::class);
    }
}
