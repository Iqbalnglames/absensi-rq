<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenHalaqah extends Model
{
    protected $guarded = [];
    
    public function murid()
    {
        return $this->belongsTo(Murid::class);
    }

    public function jurnal_halaqah()
    {
        return $this->belongsTo(JurnalTahfidz::class, 'jurnal_tahfidzs');
    }
}
