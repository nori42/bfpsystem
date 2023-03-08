<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    public function establishment()
    {
        return $this->hasMany(Establishment::class);
    }
    use HasFactory;
}
