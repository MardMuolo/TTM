<?php

namespace App\Models;

use App\Models\Demande;
use App\Models\Validation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Livrable extends Model
{
    use HasFactory;

    protected $casts = [
        'file' => 'array',
    ];


    protected $table = 'livrables';
    protected $fillable = ['nom', 'description','file','demande_id'];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }

    public function validations()
    {
        return $this->hasMany(Validation::class);
    }
}
