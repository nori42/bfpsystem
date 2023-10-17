<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Firedrill extends Model
{
    use HasFactory, SoftDeletes;

    public function establishment(){
        return $this->belongsTo(Establishment::class);
    }

    public function receipt(){
        
        return $this->belongsTo(Receipt::class);
    }
}
