<?php

namespace Database\Seeders;

use App\Models\Aula;
use Illuminate\Database\Seeder;

class AulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // AULAS
        Aula::create([
            'codigo' => 'A22',
            'CAPACIDAD' => 14,
        ]);
        Aula::create([
            'codigo' => 'B12',
            'CAPACIDAD' => 10,
        ]);
    }
}
