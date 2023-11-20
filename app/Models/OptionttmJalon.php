<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionttmJalon extends Model
{
    use HasFactory;

    protected $table = 'optionttm_jalon';

    protected $fillable = ['option_ttm_id', 'jalon_id'];
}
