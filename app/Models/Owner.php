<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    public $timestamps = false;

    public function establishment() : HasMany
    {
        return $this->hasMany(Establishment::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function corporate()
    {
        return $this->belongsTo(Corporate::class);
    }
    use HasFactory;
}
