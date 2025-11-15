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
        // Usamos Schema::table porque la tabla 'users' ya existe
        Schema::table('users', function (Blueprint $table) {
            // Añadimos la columna rol_id DESPUÉS de la columna 'password'
            // La hacemos 'nullable' por si tienes usuarios antiguos sin rol asignado
            $table->unsignedBigInteger('rol_id')->nullable()->after('password');

            // Creamos la llave foránea que conecta users.rol_id con roles.id
            $table->foreign('rol_id')->references('id')->on('roles')->onDelete('set null');
            // onDelete('set null') significa que si borras un rol, los usuarios con ese rol_id se quedan con rol_id = NULL
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Esto es lo que pasaría si haces php artisan migrate:rollback
        Schema::table('users', function (Blueprint $table) {
            // Primero borramos la llave foránea (importante el nombre: users_rol_id_foreign)
            $table->dropForeign(['rol_id']);
            // Luego borramos la columna
            $table->dropColumn('rol_id');
        });
    }
};
