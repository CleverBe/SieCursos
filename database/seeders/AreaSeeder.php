<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    }
}
