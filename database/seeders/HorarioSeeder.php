<?php

namespace Database\Seeders;

use App\Models\Horario;
use Illuminate\Database\Seeder;

class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Horario de Reparacion de celulares
        Horario::create([
            'lunes' => 'Lu',
            'martes' => 'NO',
            'miercoles' => 'Mi',
            'jueves' => 'NO',
            'viernes' => 'Vi',
            'sabado' => 'NO',
            'domingo' => 'NO',
            'modalidad' => 'PRESENCIAL',
            'periodo' => '2022-12',
            'hora_inicio' => '10:30',
            'hora_fin' => '12:30',
            'fecha_inicio' => '2022-12-01',
            'fecha_fin' => '2023-03-01',
            'dia_de_cobro' => 5,
            'horas_capacitacion' => 72,
            'costo_curso' => 1200,
            'costo_matricula' => 100,
            'duracion_meses' => 3,
            'pago_cuota' => 400,
            'estado' => 'VIGENTE',
            'aula_id' => '1',
            'professor_id' => '2',
            'asignatura_id' => '1',
        ]);
        // Horario de Photoshop
        Horario::create([
            'lunes' => 'Lu',
            'martes' => 'Ma',
            'miercoles' => 'Mi',
            'jueves' => 'Ju',
            'viernes' => 'Vi',
            'sabado' => 'NO',
            'domingo' => 'NO',
            'modalidad' => 'PRESENCIAL',
            'periodo' => '2022-12',
            'hora_inicio' => '15:00',
            'hora_fin' => '16:30',
            'fecha_inicio' => '2022-12-05',
            'fecha_fin' => '2023-02-05',
            'dia_de_cobro' => 5,
            'horas_capacitacion' => 70,
            'costo_curso' => 1000,
            'costo_matricula' => 100,
            'duracion_meses' => 2,
            'pago_cuota' => 500,
            'estado' => 'VIGENTE',
            'aula_id' => 2,
            'professor_id' => 3,
            'asignatura_id' => 2,
        ]);
    }
}
