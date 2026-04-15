<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perizinan extends Model
{
    protected $guarded = [];

    public function murid()
    {
        return $this->belongsTo(Murid::class);
    }
}
