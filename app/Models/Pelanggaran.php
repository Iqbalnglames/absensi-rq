<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    public function pelanggaran()
    {
        return $this->hasMany(CatatanPelanggaran::class);
    }
}
