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
        $roleProfessor = Role::where('name', 'PROFESSOR')->get()->first();

        $subir_material = Permission::create([
            'name' => 'subir_material',
            'guard_name' => 'web',
        ]);
        $editar_material = Permission::create([
            'name' => 'editar_material',
            'guard_name' => 'web',
        ]);
        $eliminar_material = Permission::create([
            'name' => 'eliminar_material',
            'guard_name' => 'web',
        ]);

        $roleProfessor->givePermissionTo($subir_material);
        $roleProfessor->givePermissionTo($editar_material);
        $roleProfessor->givePermissionTo($eliminar_material);
    }
}
