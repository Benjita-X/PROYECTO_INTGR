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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            
            // Columna para conectar con la tabla 'casos'
            $table->foreignId('caso_id')
                  ->constrained('casos')        // Apunta a la tabla 'casos'
                  ->onDelete('cascade');     // Si se borra un caso, se borran sus documentos
            
            // Columnas para guardar la info del archivo
            $table->string('ruta');               // El path en el disco (ej: 'casos/1/archivo.pdf')
            $table->string('nombre_original');    // El nombre que subió el usuario
            $table->string('mime_type')->nullable(); // El tipo de archivo (ej: 'application/pdf')
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentos');
    }
};
