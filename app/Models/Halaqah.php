<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Halaqah extends Model
{
    protected $guarded = []; 
    
    public function jam_halaqah()
    {
        return $this->hasMany(JamHalaqah::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function murid()
    {
        return $this->hasMany(Murid::class);
    }
}
