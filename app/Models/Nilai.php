<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $guarded = []; 
    
    public function murid(){
        return $this->belongsTo(Murid::class);
    }
    public function mapel(){
        return $this->belongsTo(Mapel::class);
    }
}
