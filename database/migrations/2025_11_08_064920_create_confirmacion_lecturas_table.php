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
        Schema::create('confirmacion_lecturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // El Docente
            $table->foreignId('caso_id')->constrained('casos')->onDelete('cascade'); // El Caso
            $table->timestamps();

            // Asegurarnos de que un docente solo pueda confirmar un caso una vez
            $table->unique(['user_id', 'caso_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('confirmacion_lecturas');
    }
};
