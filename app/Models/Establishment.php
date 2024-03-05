<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Establishment extends Model
{
    
    use HasFactory, SoftDeletes;

    protected $table = 'establishments';

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function inspection()
    {
        return $this->hasMany(Inspection::class);
    }
    
    public function firedrill()
    {
        return $this->hasMany(Firedrill::class);
    }

    public function getOwnerName($isMiddleInitial = TRUE){
        $firstName = $this->owner->first_name;
        $middleName = $this->owner->middle_name;
        $lastName = $this->owner->last_name;

        if($isMiddleInitial && $middleName != NULL){
            return "{$firstName} {$middleName[0]}. {$lastName}";
        } else {
            return "{$firstName} {$middleName} {$lastName}";
        }

        // if middle name is null return without
        return "{$firstName} {$lastName}";

    }

    public function getCompanyName(){
        return $this->owner->corporate_name;
    }

    

    public function getOwnerBoth($reversed = FALSE){
        if($this->getOwnerName() != NULL && $this->getOwnerName() != NULL){
            if($reversed)
             return $this->getCompanyName().' '.$this->getOwnerName();
             
             //OwnerName first in order is Default  
             return $this->getOwnerName().' '.$this->getCompanyName();
        }

        return $this->getOwnerName() ? $this->getOwnerName() : $this->getCompanyName();
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($establishment) {
            $establishment->inspection()->delete(); // This will delete associated inspections
            $establishment->firedrill()->delete(); // This will delete associated inspections
        });
    }
}
