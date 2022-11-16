<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ADMIN
        $roleAdmin = Role::where('name', 'ADMIN')->get()->first();
        // PROFESOR
        $roleProfessor = Role::where('name', 'PROFESSOR')->get()->first();
        // PROFESOR
        $roleEstudent = Role::where('name', 'STUDENT')->get()->first();


        // PERMISOS
        $ver_usuarios = Permission::create([
            'name' => 'ver_usuarios',
        ]);
        $ver_aulas = Permission::create([
            'name' => 'ver_aulas',
        ]);
        $ver_areas = Permission::create([
            'name' => 'ver_areas',
        ]);
        $ver_cursos = Permission::create([
            'name' => 'ver_cursos',
        ]);
        $ver_horarios = Permission::create([
            'name' => 'ver_horarios',
        ]);
        $ver_inscripciones = Permission::create([
            'name' => 'ver_inscripciones',
        ]);
        $generar_certificado = Permission::create([
            'name' => 'generar_certificado',
        ]);
        $ver_solicitudes = Permission::create([
            'name' => 'ver_solicitudes',
        ]);
        $ver_solicitud = Permission::create([
            'name' => 'ver_solicitud',
        ]);
        $ver_report_Estudiantes = Permission::create([
            'name' => 'ver_report_Estudiantes',
        ]);
        $export_report_Estudiantes = Permission::create([
            'name' => 'export_report_Estudiantes',
        ]);
        $ver_report_Pagos = Permission::create([
            'name' => 'ver_report_Pagos',
        ]);
        $export_report_Pagos = Permission::create([
            'name' => 'export_report_Pagos',
        ]);
        $ver_inicio_aulas = Permission::create([
            'name' => 'ver_inicio_aulas',
        ]);
        $ver_inicio_curso = Permission::create([
            'name' => 'ver_inicio_curso',
        ]);
        $subir_material = Permission::create([
            'name' => 'subir_material',
        ]);
        $editar_material = Permission::create([
            'name' => 'editar_material',
        ]);
        $eliminar_material = Permission::create([
            'name' => 'eliminar_material',
        ]);
        $ver_calificar = Permission::create([
            'name' => 'ver_calificar',
        ]);
        $ver_lista = Permission::create([
            'name' => 'ver_lista',
        ]);
        $ver_mis_pagos = Permission::create([
            'name' => 'ver_mis_pagos',
        ]);
        $ver_mis_notas = Permission::create([
            'name' => 'ver_mis_notas',
        ]);

        // PERMISOS ADMIN
        $roleAdmin->givePermissionTo($ver_usuarios);
        $roleAdmin->givePermissionTo($ver_aulas);
        $roleAdmin->givePermissionTo($ver_areas);
        $roleAdmin->givePermissionTo($ver_cursos);
        $roleAdmin->givePermissionTo($ver_horarios);
        $roleAdmin->givePermissionTo($ver_inscripciones);
        $roleAdmin->givePermissionTo($generar_certificado);
        $roleAdmin->givePermissionTo($ver_solicitudes);
        $roleAdmin->givePermissionTo($ver_solicitud);
        $roleAdmin->givePermissionTo($ver_report_Estudiantes);
        $roleAdmin->givePermissionTo($export_report_Estudiantes);
        $roleAdmin->givePermissionTo($ver_report_Pagos);
        $roleAdmin->givePermissionTo($export_report_Pagos);

        // PERMISOS PROFESSOR
        $roleProfessor->givePermissionTo($ver_inicio_aulas);
        $roleProfessor->givePermissionTo($ver_inicio_curso);
        $roleProfessor->givePermissionTo($subir_material);
        $roleProfessor->givePermissionTo($editar_material);
        $roleProfessor->givePermissionTo($eliminar_material);
        $roleProfessor->givePermissionTo($ver_calificar);
        $roleProfessor->givePermissionTo($ver_lista);

        // PERMISOS STUDENT
        $roleEstudent->givePermissionTo($ver_inicio_aulas);
        $roleEstudent->givePermissionTo($ver_inicio_curso);
        $roleEstudent->givePermissionTo($ver_mis_pagos);
        $roleEstudent->givePermissionTo($ver_mis_notas);
    }
}
