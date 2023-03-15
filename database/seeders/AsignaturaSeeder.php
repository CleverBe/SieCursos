<?php

namespace Database\Seeders;

use App\Models\Asignatura;
use Illuminate\Database\Seeder;

class AsignaturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ASIGNATURAS
        Asignatura::create([
            'nombre' => 'Mantenimiento y reparación de celulares',
            'descripcion' => 'Aprende a diagnosticar y reparar fallas de hardware de celualres, cambio de componentes, cambio de pantallas.',
            'area_id' => 2,
        ]);
        Asignatura::create([
            'nombre' => 'Photoshop desde 0',
            'descripcion' => 'Aprende a hacer diseños únicos en este curso práctico desde 0.',
            'area_id' => 1,
        ]);
        Asignatura::create([
            'nombre' => 'Herramientas Office nivel básico',
            'descripcion' => 'Aprende a utilizar las herramientas de Office en este curso práctico desde 0.',
            'area_id' => 3,
        ]);
    }
}
