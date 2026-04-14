<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $guarded = [];
    
    public function pelanggaran()
    {
        return $this->hasMany(CatatanPelanggaran::class);
    }
}
