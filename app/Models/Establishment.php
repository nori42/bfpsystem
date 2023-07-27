<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Establishment extends Model
{
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function insection()
    {
        return $this->hasMany(Inspection::class);
    }
    
    public function firedrill()
    {
        return $this->hasMany(Firedrill::class);
    }

    public function evaluation()    
    {
        return $this->hasMany(Evaluation::class);
    }

    use HasFactory, SoftDeletes;
}
