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
            // Cambiamos la columna 'estado' a un string de 50 caracteres
            // El método ->change() modifica la columna existente.
            $table->string('estado', 50)->change();
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
            // Esto revierte el cambio si es necesario (asumimos que era de 10)
            $table->string('estado', 10)->change();
        });
    }
};