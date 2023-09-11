<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'personnel';

    public function user(){
       return $this->belongsTo(User::class);
    }
}
