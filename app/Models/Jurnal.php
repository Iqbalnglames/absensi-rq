<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $guarded = [];
    
    public function jadwal(){
        return $this->belongsTo(Jadwal::class, 'jadwal_mengajar_id');
    }
}
