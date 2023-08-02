<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuildingPlan extends Model
{
    use HasFactory, SoftDeletes;
    public function owner(){
        return $this->belongsTo(Owner::class);
    }

    public function receipt(){
        return $this->belongsTo(Receipt::class);
    }

    public function building(){
        return $this->belongsTo(Building::class);
    }
    
    public function evaluation(){
        return $this->hasMany(BuildingPlan::class);
    }
}
