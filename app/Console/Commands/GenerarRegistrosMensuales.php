<?php

namespace App\Console\Commands;

use App\Models\Estudiante;
use App\Models\PagoMensual;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerarRegistrosMensuales extends Command
{
    protected $signature = 'app:generar-registros-mensuales';
    protected $description = 'Genera automáticamente registros mensuales para los estudiantes';

    public function handle()
    {
        try {
            $estudiantes = Estudiante::all();
            $mesActual = Carbon::now()->month;
            $anioActual = Carbon::now()->year;

            foreach ($estudiantes as $estudiante) {
                $pagoExistente = PagoMensual::where('estudiante_id', $estudiante->id)
                    ->where('mes', $mesActual)
                    ->where('anio', $anioActual)
                    ->first();

                if (!$pagoExistente) {
                    PagoMensual::create([
                        'estudiante_id' => $estudiante->id,
                        'mes' => $mesActual,
                        'anio' => $anioActual,
                        'fecha' => Carbon::now(),
                        'pagado' => false,
                    ]);
                }
            }

            $this->info('Registros mensuales generados con éxito.');
        } catch (\Exception $e) {
            Log::error('Error al generar registros mensuales: ' . $e->getMessage());
            $this->error('Hubo un error al generar registros mensuales. Consulta los logs para obtener más información.');
        }
    }

}
