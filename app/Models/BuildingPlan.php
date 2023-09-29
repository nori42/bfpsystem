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

    public function getOwnerName(){
        $owner = Owner::find($this->owner_id);

        $ownerName = $owner->first_name.' '.' '.$owner->last_name;

        if($owner->corporate_name != null)
            $ownerName = $ownerName.'/'.$owner->corporate_name;

        if($owner->corporate_name != null && $owner->last_name == null)
        $ownerName = $owner->corporate_name;
        
        return $ownerName;
    }
}
