<?php

namespace Database\Seeders;

use App\Models\CategoriaCriterio;
use App\Models\Criterio;
use Illuminate\Database\Seeder;

class CriteriosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Criterio::create(['nombre' => 'Total Prácticas y Asistencias', 'porcentaje' => 15, 'total' => 0]);
        Criterio::create(['nombre' => 'Total Laboratorios', 'porcentaje' => 35, 'total' => 35]);
        Criterio::create(['nombre' => 'Total Nota Exámenes', 'porcentaje' => 50, 'total' => 0]);

        CategoriaCriterio::create(['nombre' => 'Total Asistencia', 'porcentaje' => 5, 'total' => 0, 'asistencia' => true, 'criterio_id' => 1]);
        CategoriaCriterio::create(['nombre' => 'Total Trabajos', 'porcentaje' => 10, 'total' => 5, 'criterio_id' => 1]);
        CategoriaCriterio::create(['nombre' => 'Total Examenes', 'porcentaje' => 20, 'total' => 30, 'criterio_id' => 3]);
        CategoriaCriterio::create(['nombre' => 'Total Examenes Finales', 'porcentaje' => 30, 'total' => 0, 'criterio_id' => 3]);
    }
}

