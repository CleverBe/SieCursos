<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\AlumnoHorario;
use App\Models\User;
use Illuminate\Database\Seeder;

class EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* $user_alumno = User::create([
            'name' => 'Mauricio Claros',
            'email' => 'mauri098@gmail.com',
            'cedula' => '7895841',
            'profile' => 'STUDENT',
            'status' => 'ACTIVE',
            'password' => bcrypt('7895841'),
            'image' => 'noimage.png'
        ]);

        $user_alumno->syncRoles('STUDENT');

        $alumno= Alumno::create([
            'nombre' => 'Mauricio Claros',
            'telefono' => '69151412',
            'user_id' => $user_alumno->id,
        ]);

        AlumnoHorario::create([
            'fecha_inscripcion' => '2022-12-07 21:48:00',
            'primera_nota' => '0',
            'segunda_nota' => '0',
            'nota_final' => '0',
            'estado' => 'VIGENTE',
            'alumno_id' => $alumno->id,
            'horario_id' => 1,
        ]); */

    }
}
