<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inspection extends Model
{
    use HasFactory, SoftDeletes;

    public function receipt(){
        return $this->belongsTo(Receipt::class);
    }

    public function establishment(){
        return $this->belongsTo(Establishment::class);
    }

    public function add(){
        
    }
}
