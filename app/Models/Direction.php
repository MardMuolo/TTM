<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function direction_users(){
        return $this->hasMany(DirectionUser::class);
    }
}
