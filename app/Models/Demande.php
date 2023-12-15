<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_demande_id',
        'jalon_id',
    ];

    public function categoryDemande()
    {
        return $this->belongsTo(CategoryDemande::class, 'category_demande_id');
    }

    public function jalon()
    {
        return $this->belongsTo(Jalon::class, 'jalon_id');
    }

    public function demandeJalons()
    {
        return $this->hasMany(DemandeJalon::class);
    }
}
