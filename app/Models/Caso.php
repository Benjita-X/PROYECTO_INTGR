<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caso extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rut_estudiante',       // <-- AÑADIDO
        'nombre_estudiante',    // <-- RENOMBRADO (antes 'estudiante')
        'correo_estudiante',    // <-- AÑADIDO
        'carrera',
        'ajustes_propuestos',   // <-- RENOMBRADO (antes 'ajuste')
        'estado',               // Mantenemos estado
        'asesoria_id',          // Mantenemos asesor ID
        'director_id', 
        'motivo_decision',      // No es "fillable" al crear
    ];


    /**
     * RELACIÓN: Un Caso pertenece a un Usuario (el Asesor que lo creó).
     */
    public function asesor()
    {
        // Asegúrate que la llave foránea sea 'asesoria_id' en tu tabla casos
        return $this->belongsTo(User::class, 'asesoria_id'); 
    }

     /**
     * RELACIÓN: Un Caso pertenece a un Usuario (el Director que lo valida).
     */
    public function director()
    {
         // Asegúrate que la llave foránea sea 'director_id' en tu tabla casos
        return $this->belongsTo(User::class, 'director_id');
    }

    /**
     * RELACIÓN: Un Caso puede tener muchos Documentos.
     * (Necesitarás crear el modelo Documento y su tabla/migración más adelante)
     */
    public function documentos()
    {

        // Asumiendo que crearás un modelo Documento y la FK es 'caso_id'
        return $this->hasMany(\App\Models\Documento::class); 
    }

    /**
    * Los docentes (usuarios) que han confirmado la lectura de este caso.
    */
    public function docentesQueConfirmaron()
    {
        return $this->belongsToMany(User::class, 'confirmacion_lecturas');
    }
}

