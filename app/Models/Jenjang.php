<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jenjang extends Model
{
    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function jamPelajarans()
    {
        return $this->hasMany(JamPelajaran::class);
    }
}
