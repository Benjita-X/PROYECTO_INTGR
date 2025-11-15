<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles'; // <-- AÑADE ESTA LÍNEA

    protected $fillable = ['nombre_rol'];

    /**
     * RELACIÓN: Un Rol puede tener muchos Usuarios.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}