<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Asegúrate de importar DB

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Limpiamos la tabla para evitar duplicados si se corre varias veces
        DB::table('roles')->truncate();
        
        // Definimos los roles basados en tus informes
        $roles = [
            ['nombre_rol' => 'Administrador'],
            ['nombre_rol' => 'Asesoría Pedagógica'],
            ['nombre_rol' => 'Director de Carrera'],
            ['nombre_rol' => 'Docente'],
            ['nombre_rol' => 'Estudiante'], // Rol por defecto para el registro
        ];

        // Insertamos los roles en la tabla
        DB::table('roles')->insert($roles);
    }
}

