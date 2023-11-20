<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_users', 'user_id', 'project_id')->withPivot('role', 'status');
    }

    public function lineManager()
    {
        return $this->belongsTo(User::class, 'line_manager');
    }

    public function collaborateurs()
    {
        return $this->hasMany(User::class, 'line_manager', 'id');
    }

    public function demandeJalons()
    {
        return $this->hasMany(DemandeJalon::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // Vérification pour savoir si l'utilisateur à plusieurs rôles ou contient au moins un rôles
    public function hasRoles(array $roles)
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    public function direction_user()
    {
        return $this->hasOne(DirectionUser::class);
    }

    public function metiers()
    {
        return $this->belongsTo(Metier::class);
    }
}
