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
        Schema::create('casos', function (Blueprint $table) {
            $table->id();
            $table->string('estudiante');
            $table->string('carrera');
            $table->string('ajuste');
            $table->enum('estado', ['pendiente', 'aceptado', 'rechazado', 'reevaluacion'])->default('pendiente');
            $table->unsignedBigInteger('asesoria_id');
            $table->unsignedBigInteger('director_id')->nullable();
            $table->text('motivo')->nullable();
            $table->timestamps();

            $table->foreign('asesoria_id')->references('id')->on('users');
            $table->foreign('director_id')->references('id')->on('users');
            
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('casos');
    }
};
