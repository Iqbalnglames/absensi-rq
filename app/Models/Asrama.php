<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asrama extends Model
{
    protected $guarded = [];
    
    public function pengasuh_asrama(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jenjang(){
        return $this->belongsTo(Jenjang::class);
    }
}
