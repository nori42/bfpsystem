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

    public function getOwnerName(){
        $owner = Owner::find($this->owner_id);

        $ownerName = $owner->first_name.' '.' '.$owner->last_name;

        if($owner->corporate_name != null)
            $ownerName = $ownerName.'/'.$owner->corporate_name;

        if($owner->corporate_name != null && $owner->last_name == null)
        $ownerName = $owner->corporate_name;
        
        return $ownerName;
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
