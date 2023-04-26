<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firedrill extends Model
{
    use HasFactory;

    public function establishment(){
        return $this->belongsTo(Establishment::class);
    }

    public function receipt(){
        
        return $this->belongsTo(Receipt::class);
    }
}
