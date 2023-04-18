<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;

    public function receipt(){
        return $this->belongsTo(Receipt::class);
    }

    public function establishment(){
        return $this->belongsTo(Establishment::class);
    }
}
