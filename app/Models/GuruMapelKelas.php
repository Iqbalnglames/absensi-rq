<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruMapelKelas extends Model
{
   protected $table = 'mapel_gurus';

   protected $guarded = [];

    public function guru()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
