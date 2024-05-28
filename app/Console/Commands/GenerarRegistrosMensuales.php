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
            $estudiantes = Estudiante::where('estado', 1)->get();
            $mesActual = Carbon::now()->month;
            $anioActual = Carbon::now()->year;
            foreach ($estudiantes as $estudiante) {
                $pagoExistente = PagoMensual::where('estudiante_id', $estudiante->id)
                    ->where('mes', $mesActual)
                    ->where('anio', $anioActual)
                    ->where('metodo_id', 1)
                    ->first();
                if (!$pagoExistente) {
                    // Cambiar el estado del estudiante a false
                    $estudiante->estado = false;
                    // Guardar el cambio en la base de datos
                    $estudiante->save();
                }
            }
            $this->info('Registros mensuales generados con éxito.');
        } catch (\Exception $e) {
            $this->error('Hubo un error al generar registros mensuales. Consulta los logs para obtener más información.');
        }
    }

}
