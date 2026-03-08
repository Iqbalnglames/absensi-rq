<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamPelajaran extends Model
{
    protected $guarded = []; 

    public function jadwal(){
        return $this->belongsToMany(Jadwal::class, 'jam_mapels');
    }

    public function jenjang(){
        return $this->belongsTo(Jenjang::class);
    }
}
