<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\CursoHabilitado;
use App\Models\Estudiante;
use App\Models\Horario;
use App\Models\PagoMensual;
use App\Models\Semestre;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function reportsEstudents() {
        $horarios = Horario::all();
        $semestres = Semestre::all();
        return view('admin.informes.estudiantes', compact('horarios', 'semestres'));
    }

    public function searchEstudiantes(Request $request) {
        try {
            $query = Estudiante::with(['persona', 'contacto', 'turnos', 'inscripciones']);

            if ($request->has('horario') && $request->horario != '') {
                $query->where('turno_id', $request->horario);
            }

            if ($request->has('semestre') && $request->semestre != '') {
                $query->where('grado', $request->semestre);
            }

            if ($request->has('estado') && $request->estado != '') {
                $query->where('estado', (bool)$request->estado);
            }

            if ($request->has('graduado') && $request->graduado != '') {
                $graduado = $request->graduado === 'Si';
                $query->where('graduado', $graduado);
            }

            if ($request->has('promedio') && $request->promedio != '') {
                $query->whereHas('calificaciones', function ($q) use ($request) {
                    $q->havingRaw('AVG(nota) >= ?', [$request->promedio]);
                });
            }

            $resultados = $query->get()->map(function($estudiante) {
                $fechaActual = Carbon::now();
                $edad = $fechaActual->diffInYears($estudiante->fecha_nacimiento);
                $semest = Semestre::find($estudiante->grado);
                return [
                    'Estudiante' => $estudiante->persona->nombre . ' ' . $estudiante->persona->ap_paterno . ' ' . $estudiante->persona->ap_materno,
                    'CI' => $estudiante->persona->ci,
                    'E-Mail' => $estudiante->persona->email,
                    'Turno' => $estudiante->turnos->turno,
                    'Semestre' => $semest->nombre,
                    'Fecha Inscripción' => Carbon::parse($estudiante->created_at)->format('Y-m-d'),
                    'Edad' => $edad,
                ];
            });

            return response()->json(['data' => $resultados], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al realizar la operación: ' . $e->getMessage()
            ], 500);
        }
    }

    private function mesesAnio() {
        return [
            '1' => 'Enero',
            '2' => 'Febrero',
            '3' => 'Marzo',
            '4' => 'Abril',
            '5' => 'Mayo',
            '6' => 'Junio',
            '7' => 'Julio',
            '8' => 'Agosto',
            '9' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];        
    }

    public function reportsPagos() {
        //$estudiantes = Estudiante::all();
        $currentYear = date('Y');
        $startYear = $currentYear - 5;
        $months = $this->mesesAnio();
        return view('admin.informes.pagos', compact('startYear', 'months'));
    }
    
    public function searchPagos(Request $request) {
        try {
            $query = PagoMensual::query();
            if ($request->has('selectEstudiante') && $request->selectEstudiante != '') {
                $query->where('estudiante_id', $request->selectEstudiante);
            }
    
            // Filtrar por año si se seleccionó
            if ($request->has('year') && $request->year != '' ) {
                $query->where('anio', $request->year);
            }
    
            // Filtrar por mes si se seleccionó
            if ($request->has('selectedMonth')  && $request->selectedMonth != '') {
                $query->where('mes', $request->selectedMonth);
            }
            if ($request->estado == 0) {
                $resultados = $query->get()->map(function($item) {
                    return [
                        'Estudiante' => $item->estudiante->persona->nombre .' '.$item->estudiante->persona->ap_paterno .' '.$item->estudiante->persona->ap_materno,
                        'CI' => $item->estudiante->persona->ci,
                        'Monto' => $item->monto,
                        'Mes' => $this->mesesList($item->mes),
                        'Año' => $item->anio,
                        'Fecha' => Carbon::parse($item->fecha)->format('Y-m-d'),
                    ];
                });
            } else {
                $resultados = $query->get()->groupBy('estudiante_id')->map(function ($pagos, $estudianteId) use ($request) {
                    $estudiante = $pagos->first()->estudiante;
                    $totalMonto = $pagos->sum('monto');
                    $resultado = [
                        'Estudiante' => $estudiante->persona->nombre . ' ' . $estudiante->persona->ap_paterno . ' ' . $estudiante->persona->ap_materno,
                        'CI' => $estudiante->persona->ci,
                        'Total' => 'Bs. ' . $totalMonto,
                        'Año' => $request->year
                    ];
                    // Si se filtró por mes y año, mostrar mes y año
                    if ($request->has('selectedMonth') && $request->selectedMonth != '') {
                        $resultado['Mes'] = $this->mesesList($request->selectedMonth);
                    }
        
                    return $resultado;
                })->values();

            }
    
            return response()->json(['data' => $resultados], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al realizar la operación: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function mesesList($item) {
        $meses = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];
        foreach ($meses as $key => $value) {
            if ($key == $item) {
                $mes = $value;
            }
        }
        return $mes;
    }

    public function reportsAsistencias() {
        $materias = CursoHabilitado::where('estado', 1)->get();
        $months = $this->mesesAnio();
        $currentYear = date('Y');
        $startYear = $currentYear - 1;
        return view('admin.informes.asistencias', compact('materias', 'months', 'currentYear', 'startYear'));
    }

    public function searchAsistencias(Request $request) {
        $rules = [
            'materia' => 'required|numeric|exists:curso_habilitados,id',
            'meses' => 'nullable|numeric',
            'year' => 'required|digits:4|integer',
        ];
        $request->validate($rules);

        try {
            $query = Asistencia::query();
            
            // Filtrar por materia si se proporcionó
            if ($request->has('materia') && $request->materia != '') {
                $query->where('curso_id', $request->materia);
            }
            
            // Filtrar por año
            if ($request->has('year') && $request->year != '') {
                $query->whereYear('fecha', $request->year);
            }
            
            // Filtrar por meses si se proporcionaron
            if ($request->has('meses') && $request->meses != '') {
                //$query->whereIn(DB::raw('MONTH(fecha)'), $request->meses);
                $query->whereMonth('fecha', $request->meses);
            }
            
            // Obtener los resultados y agruparlos por estudiante y materia
            $resultados = $query->get()->groupBy(['curso_id', 'estudiante_id'])->map(function ($group) use ($request) {
                // Mapear los datos agrupados a la estructura deseada
                return $group->map(function ($items) use ($request) {
                    $curso = CursoHabilitado::find($items->first()->curso_id);
                    $estudiante = Estudiante::find($items->first()->estudiante_id);

                    $cantidadAsistencias = $items->where('asistencia', 'P')->count();
                    $cantidadFaltas = $items->filter(function ($item) {
                        return $item->asistencia === 'F' || $item->asistencia === 'L';
                    })->count();
                    
                    return [
                        'Materia' => $curso->curso->nombre ?? 'Sin nombre',
                        'Estudiante' => $estudiante->persona->nombre . ' ' . $estudiante->persona->ap_paterno . ' ' . $estudiante->persona->ap_materno,
                        'CI/Nit' => $estudiante->persona->ci,
                        'Cantidad de Asistencias' => $cantidadAsistencias,
                        'Cantidad de Faltas' => $cantidadFaltas,
                        'Año' => $request->year,
                    ];
                });
            });

            // Aplanar los resultados
            $resultados = $resultados->flatten(1);
            return response()->json(['data' => $resultados], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al realizar la operación: ' . $e->getMessage()
            ], 500);
        }
    }

}
