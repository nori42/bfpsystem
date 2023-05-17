<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingPlan extends Model
{
    use HasFactory;
    public function owner(){
        return $this->belongsTo(Owner::class);
    }

    public function receipt(){
        return $this->belongsTo(Receipt::class);
    }

    public function building(){
        return $this->belongsTo(Building::class);
    }
}
