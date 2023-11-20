<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectOptionttmJalon extends Model
{
    use HasFactory;

    protected $table = 'project_optionttm_jalon';

    protected $fillable = ['project_id', 'option_ttm_id', 'jalon_id', 'debutDate', 'echeance', 'status'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function optionttm()
    {
        return $this->belongsTo(OptionTtm::class);
    }

    public function jalon()
    {
        return $this->belongsTo(Jalon::class);
    }

    public function historiqueDates()
    {
        return $this->hasMany(HistoriqueDate::class);
    }

    public function demandeJalons()
    {
        return $this->hasMany(DemandeJalon::class);
    }
}
