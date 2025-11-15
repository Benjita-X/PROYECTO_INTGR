<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol_id', // <-- AÑADIDO para poder asignar el rol al registrar
    ];

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

    /**
     * RELACIÓN: Un Usuario pertenece a un Rol.
     */
    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

    /**
     * RELACIÓN: Un Usuario (Asesor) puede crear muchos Casos.
     */
    public function casosCreados()
    {
        return $this->hasMany(Caso::class, 'asesoria_id');
    }

    public function casosConfirmados()
    {
        return $this->belongsToMany(Caso::class, 'confirmacion_lecturas');
    }
}