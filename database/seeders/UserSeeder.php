<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Area;
use App\Models\Asignatura;
use App\Models\Aula;
use App\Models\Professor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $porAsignar = User::create([
            'email' => '123@gmail.com',
            'name' => 'Por Asignar',
            'cedula' => '999999999',
            'profile' => 'PROFESSOR',
            'status' => 'ACTIVE',
            'password' => bcrypt('123')
        ]);
        Professor::create([
            'nombre' => 'Por Asignar',
            'telefono' => '',
            'user_id' => $porAsignar->id,
        ]);

        $usuario = User::create([
            'email' => 'cleverbernal123@gmail.com',
            'name' => 'Clever Bernal',
            'cedula' => '9406795',
            'profile' => 'PROFESSOR',
            'status' => 'ACTIVE',
            'password' => bcrypt('123')
        ]);
        Professor::create([
            'nombre' => 'Clever Bernal',
            'telefono' => '6187236',
            'user_id' => $usuario->id,
        ]);

        $administrador = User::create([
            'email' => 'admin@admin.com',
            'name' => 'Carlos',
            'cedula' => '82827788',
            'profile' => 'ADMIN',
            'status' => 'ACTIVE',
            'password' => bcrypt('123')
        ]);
        Admin::create([
            'nombre' => 'Carlos',
            'telefono' => '',
            'user_id' => $administrador->id,
        ]);

        $roles = [
            [
                'name' => 'ADMIN',
                'guard_name' => 'web'
            ],
            [
                'name' => 'PROFESSOR',
                'guard_name' => 'web'
            ],
            [
                'name' => 'STUDENT',
                'guard_name' => 'web'
            ],
        ];

        foreach ($roles as $rol) {
            Role::create($rol);
        }

        $usuario->syncRoles('PROFESSOR');
        $porAsignar->syncRoles('PROFESSOR');
        $administrador->syncRoles('ADMIN');

        // AULAS
        Aula::create([
            'codigo' => 'A22',
            'CAPACIDAD' => 14,
        ]);
        Aula::create([
            'codigo' => 'B12',
            'CAPACIDAD' => 10,
        ]);
        // AREAS
        Area::create([
            'nombre' => 'Marketing'
        ]);
        Area::create([
            'nombre' => 'Electronica'
        ]);
        Area::create([
            'nombre' => 'Sistemas'
        ]);
        // ASIGNATURAS
        Asignatura::create([
            'nombre' => 'Reparación de celulares',
            'descripcion' => 'curso práctico desde 0',
            'duracion' => 3,
            'matricula' => 100,
            'costo' => 1200,
            'image' => 'noimage.jpg',
            'area_id' => 2,
        ]);
        Asignatura::create([
            'nombre' => 'Photoshop desde 0',
            'descripcion' => 'curso práctico desde 0',
            'duracion' => 3,
            'matricula' => 100,
            'costo' => 1000,
            'image' => 'noimage.jpg',
            'area_id' => 1,
        ]);
    }
}
