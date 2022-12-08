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
            'cedula' => '99999999',
            'profile' => 'PROFESSOR',
            'status' => 'ACTIVE',
            'password' => bcrypt('5894522'),
            'image' => 'noimage.png'
        ]);
        Professor::create([
            'nombre' => 'Por Asignar',
            'telefono' => '',
            'user_id' => $porAsignar->id,
        ]);

        $profesor1 = User::create([
            'email' => 'favioVillaroel@gmail.com',
            'name' => 'Favio Villaroel',
            'cedula' => '9406795',
            'profile' => 'PROFESSOR',
            'status' => 'ACTIVE',
            'password' => bcrypt('123'),
            'image' => 'noimage.png'
        ]);
        Professor::create([
            'nombre' => 'Favio Villaroel',
            'telefono' => '6187236',
            'user_id' => $profesor1->id,
        ]);

        $profesor2 = User::create([
            'email' => 'gustavoQuisbert@gmail.com',
            'name' => 'Gustavo Quisbert',
            'cedula' => '6622551',
            'profile' => 'PROFESSOR',
            'status' => 'ACTIVE',
            'password' => bcrypt('123'),
            'image' => 'noimage.png'
        ]);
        Professor::create([
            'nombre' => 'Gustavo Quisbert',
            'telefono' => '69451278',
            'user_id' => $profesor2->id,
        ]);

        $administrador = User::create([
            'email' => 'admin@admin.com',
            'name' => 'Clever Bernal Terrazas',
            'cedula' => '8282778',
            'profile' => 'ADMIN',
            'status' => 'ACTIVE',
            'password' => bcrypt('123'),
            'image' => 'noimage.png'
        ]);
        Admin::create([
            'nombre' => 'Clever Bernal Terrazas',
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

        $profesor1->syncRoles('PROFESSOR');
        $profesor2->syncRoles('PROFESSOR');
        $porAsignar->syncRoles('PROFESSOR');
        $administrador->syncRoles('ADMIN');
    }
}
