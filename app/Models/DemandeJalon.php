<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeJalon extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'pathTask',
        'contributeur',
        'deadLine',
        'date_prevue',
        'date_reelle',
        'status',
        'project_optionttm_jalon_id',
    ];

    public function projectOptionJalon()
    {
        return $this->belongsTo(ProjectOptionttmJalon::class);
    }

    public function livrables()
    {
        return $this->hasMany(Livrable::class);
    }

    public function jalons()
    {
        return $this->belongsToMany(Jalon::class);
    }

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }

    public function oneContributeur()
    {
        return $this->belongsTo(User::class, 'contributeur');
    }
}
