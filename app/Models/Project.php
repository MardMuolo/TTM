<?php
/*
Author: emmenuel badibanga
 emmanuelbadidanga250@gmail.com
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();

        static::created(function ($project) {
            $score = $project->score;

            $optionTtm = OptionTtm::where('minComplexite', '<=', $score)->where('maxComplexite', '>', $score)->first();
            if ($optionTtm) {
                $jalonsIds = $optionTtm->jalons->pluck('id')->toArray();
                foreach ($jalonsIds as $jalonId) {
                    $project->optionsJalons()->attach($optionTtm->id, [
                        'option_ttm_id' => $optionTtm->id,
                        'project_id' => $project->id,
                        'jalon_id' => $jalonId,
                    ]);
                }
            }
        });
    }

    protected $fillable = [
        'name',
        'description',
        'target',
        'type',
        'startDate',
        'endDate',
        'coast',
        'score',
        'projectOwner',
        'sponsor',
        'status'
        

    ];

    // Methode isAdmin: permet de verifier si l'utilisateur connecté est le ttmOfficer
    public static function isAdmin()
    {
        foreach (auth()->user()->roles as $user) {
            if ($user->name == env('TtmOfficer') or $user->name == 'Directeur' ) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function isDirector(){
        $projects = Project::join('project_users', 'projects.id', '=', 'project_users.project_id')
        ->join('users', 'project_users.user_id', '=', 'users.id')
        ->join('direction_users', 'users.id', '=', 'direction_users.user_id')
        ->where('direction_users.direction_id', Auth()->user()->direction_user->direction->id) // Remplacez $directionXId par l'ID de la direction spécifique
        ->where('project_users.role', 'projectOwner')
        ->select('projects.*')
        ->with('optionsJalons')
        ->get();
        return $projects;
    }

    // Méthode get: permet d'afficher les projects selon les roles de l'utilisateur connecté
    public static function get($status)
    {
        $user = auth()->user();
        if ($status) {
            $project = Project::with('users', 'optionsJalons')->get();
        } else {
            $project = $user->projects()->with('users', 'optionsJalons')->get();
        }

        return $project;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_users', 'project_id', 'user_id')->withPivot('role', 'status');
    }

    public function projectFile()
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function projectComplexityTargets()
    {
        return $this->hasMany(ProjectComplexityTarget::class);
    }

    public function projectComplexityItems()
    {
        return $this->hasMany(ProjectComplexityItem::class);
    }

    public function option_ttms()
    {
        return $this->belongsToMany(OptionTtm::class, 'project_option_jalons', 'project_id', 'option_ttm_id');
    }

    public function jalons()
    {
        return $this->optionTtm->jalons;
    }

    public function score()
    {
        return $this->hasMany(Score::class);
    }

    public function optionttm()
    {
        return $this->belongsToMany(OptionTtm::class, 'project_optionttm_jalon', 'project_id', 'option_ttm_id')->withPivot('option_ttm_id')->withTimestamps();
    }

    public function optionsJalons()
    {
        return $this->belongsToMany(Jalon::class, 'project_optionttm_jalon', 'project_id', 'jalon_id')->withPivot('option_ttm_id', 'debutDate', 'echeance', 'status')->withTimestamps();
    }
}
