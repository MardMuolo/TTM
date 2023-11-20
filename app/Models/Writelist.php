<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Writelist extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['username'];
    protected $dates = ['deleted_at'];
}
