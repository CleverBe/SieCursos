<?php

namespace Database\Seeders;

use App\Models\Admin;
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
            'password' => bcrypt('123'),
            'image' => 'noimage.png'
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
            'password' => bcrypt('123'),
            'image' => 'noimage.png'
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
            'password' => bcrypt('123'),
            'image' => 'noimage.png'
        ]);
        Admin::create([
            'nombre' => 'Carlos',
            'telefono' => '78451245',
            'user_id' => $administrador->id,
        ]);

        $roles = [
            [
                'name' => 'ADMIN',
            ],
            [
                'name' => 'PROFESSOR',
            ],
            [
                'name' => 'STUDENT',
            ],
        ];

        foreach ($roles as $rol) {
            Role::create($rol);
        }

        $usuario->syncRoles('PROFESSOR');
        $porAsignar->syncRoles('PROFESSOR');
        $administrador->syncRoles('ADMIN');
    }
}
