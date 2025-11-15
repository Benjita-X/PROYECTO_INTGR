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
            
            // Columna para guardar el ID del director que toma la decisión.
            // Es 'nullable' porque está vacío cuando se crea el caso.
            // 'after' es opcional, pero ayuda a ordenar la tabla.
            if (!Schema::hasColumn('casos', 'director_id')) {
            $table->foreignId('director_id')
                  ->nullable()
                  ->after('asesoria_id')
                  ->constrained('users')       // Apunta a la tabla 'users'
                  ->onDelete('set null'); // Si se borra el user, se pone null aquí
            }

            // Columna para guardar el comentario/razón de la decisión.
            // Usamos 'text' en lugar de 'string' para textos largos.
            if (!Schema::hasColumn('casos', 'motivo_decision')) {
            $table->text('motivo_decision')
                  ->nullable()
                  ->after('estado');
            
            }
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
            // Esto es para poder revertir la migración
            $table->dropForeign(['director_id']);
            $table->dropColumn('director_id');
            $table->dropColumn('motivo_decision');
        });
    }
};