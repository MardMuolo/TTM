<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectionUser extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function direction(){
        return $this->belongsTo(Direction::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
