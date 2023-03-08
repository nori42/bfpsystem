<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    use HasFactory;
}
