<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'caso_id',
        'ruta',
        'nombre_original',
        'mime_type',
    ];

    /**
     * RELACIÓN: Un Documento pertenece a un Caso.
     */
    public function caso()
    {
        return $this->belongsTo(Caso::class);
    }
}