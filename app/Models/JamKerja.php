<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamKerja extends Model
{
    protected $table = 'jadwal_kerjas';

    protected $guarded = ['id'];
    
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
