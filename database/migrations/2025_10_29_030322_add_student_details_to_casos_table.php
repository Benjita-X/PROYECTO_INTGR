<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('casos', function (Blueprint $table) {
            // Añadimos RUT (importante indexarlo para búsquedas futuras)
            $table->string('rut_estudiante')->after('id')->nullable()->index(); 
            // Añadimos Correo
            $table->string('correo_estudiante')->after('carrera')->nullable();
            // Cambiamos 'estudiante' a 'nombre_estudiante' para claridad
            $table->renameColumn('estudiante', 'nombre_estudiante'); 
             // Cambiamos 'ajuste' a 'ajustes_propuestos' y permitimos texto largo
            $table->text('ajuste')->change(); // Primero cambia a TEXT
            $table->renameColumn('ajuste', 'ajustes_propuestos'); // Luego renombra

            // Podríamos añadir más campos si es necesario (ej: Sede, Periodo Académico FKs)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('casos', function (Blueprint $table) {
             // Es importante definir cómo revertir los cambios EN ORDEN INVERSO
            $table->renameColumn('ajustes_propuestos', 'ajuste'); // Primero renombra
            $table->string('ajuste')->change(); // Luego revierte a string
            $table->renameColumn('nombre_estudiante', 'estudiante'); // Renombra de vuelta
            $table->dropColumn('correo_estudiante');
            $table->dropIndex(['rut_estudiante']); // Eliminar índice primero si existe
            $table->dropColumn('rut_estudiante');
        });
    }
};