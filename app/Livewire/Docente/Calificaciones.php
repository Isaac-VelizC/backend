<?php

namespace App\Livewire\Docente;

use App\Exports\CalificacionesExport;
use App\Models\Asistencia;
use App\Models\Calificacion;
use App\Models\CatCritTrabajo;
use App\Models\CategoriaCriterio;
use App\Models\Criterio;
use App\Models\CursoHabilitado;
use App\Models\Trabajo;
use App\Models\TrabajoEstudiante;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Calificaciones extends Component
{
    public $estudiantes, $idCurso;
    public CursoHabilitado $materia;
    public $trabajos, $notas;
    public function mount($id) {
        $this->idCurso = $id;
        $this->materia = CursoHabilitado::find($id);
        $curso = CursoHabilitado::with('inscripciones.estudiante')->find($id);
        $this->estudiantes = $curso->inscripciones->pluck('estudiante');
        $this->trabajos = Trabajo::where('curso_id', $curso->id)->where('estado', '!=', 'Borrador')->get();
        $this->cargarNotas();
    }
    public function cargarNotas() {
        $this->notas = [];
        $calificacionesCurso = Calificacion::where('curso_id', $this->idCurso)->get();

        foreach ($this->estudiantes as $est) {
            $this->notas[$est->id] = [];

            foreach ($this->trabajos as $tra) {
                $nota = TrabajoEstudiante::where([
                    'estudiante_id' => $est->id,
                    'trabajo_id' => $tra->id,
                ])->value('nota');

                $this->notas[$est->id][$tra->id] = $nota;
            }
            // Agrega la calificación final
            $calificacionEstudiante = $calificacionesCurso->firstWhere('estudiante_id', $est->id);
            $this->notas[$est->id]['notaFinal'] = $calificacionEstudiante ? $calificacionEstudiante->calificacion : 'N/A';
        }

    }
    public function render()
    {
        return view('livewire.docente.calificaciones');
    }
    public function calcularNotas() {
        try {
            // Verifica si hay trabajos pendientes por calificar
            $pendientes = TrabajoEstudiante::where('estado', 'Entregado')->where('curso_id', $this->idCurso)->count();

            if ($pendientes > 0) {
                // Envía un mensaje de advertencia y detén la ejecución
                session()->flash('error', 'Aún hay trabajos pendientes por calificar.');
                return;
            }
            foreach ($this->estudiantes as $value) {
                $this->calcularNotaTotal($value->id, $this->idCurso);
            }
            $this->cargarNotas();
            session()->flash('message', 'Calculo de notas Terminada correctamente');
        } catch (\Throwable $th) {
            session()->flash('error', 'Ocurrio un error: '.$th->getMessage());
        }
    }

    public function calcularNotAsistencia($idEst, $idCurso, $porcentaje) {
        // Obtener las asistencias del estudiante en el curso
        $asistencias = Asistencia::where('curso_id', $idCurso)
                                ->where('estudiante_id', $idEst)
                                ->get();

        // Filtrar las asistencias 'P' (Presentes)
        $asistenciasPresentes = $asistencias->filter(function($asistencia) {
            return $asistencia->asistencia == 'P';
        });
        // Contar las asistencias 'P'
        $cantidadPresentes = $asistenciasPresentes->count();

        // Multiplicar la cantidad de presentes por el porcentaje del criterio
        $porcentajeCriterio = $porcentaje;
        $resultadoMultiplicacion = $cantidadPresentes * $porcentajeCriterio;

        // Calcular el total de asistencias registradas
        $totalAsistencias = $asistencias->count();

        // Dividir el resultado de la multiplicación por el total de asistencias registradas
        if ($totalAsistencias > 0) {
            $notaAsistencia = $resultadoMultiplicacion / $totalAsistencias;
        } else {
            $notaAsistencia = 0;
        }

        // Redondear la nota de asistencia a un valor entero
        $notaAsistenciaRedondeada = round($notaAsistencia);

        return $notaAsistenciaRedondeada;
    }

    public function calcularNotaTotal($idEst, $idCurso) {
        $tareasEstudiante = TrabajoEstudiante::where('estudiante_id', $idEst)
            ->whereHas('trabajo', function ($query) use ($idCurso) {
                $query->where('curso_id', $idCurso);
            })->get();
        $todasLasTareas = [];
        if($tareasEstudiante) {
            foreach ($tareasEstudiante as $tareaEstudiante) {
                $tarea = $tareaEstudiante->trabajo;
                $relacionesCategorias = CatCritTrabajo::where('tarea_id', $tarea->id)->get();
                if ($relacionesCategorias->isEmpty()) {
                    $todasLasTareas[] = [
                        'id' => $tarea->id,
                        'criterio' => $tarea->criterio_id ?: null,
                        'porcentajeCriterio' => $tarea->criterio ? $tarea->criterio->porcentaje : null,
                        'categoria' => null,
                        'porcentajeCategoria' => null,
                        'nota' => $tareaEstudiante->nota,
                    ];
                } else {
                    foreach ($relacionesCategorias as $relacionCategoria) {
                        $todasLasTareas[] = [
                            'id' => $tarea->id,
                            'criterio' => $tarea->criterio_id,
                            'porcentajeCriterio' => $tarea->criterio->porcentaje,
                            'categoria' => $relacionCategoria->cat_id,
                            'porcentajeCategoria' => $relacionCategoria->categoriaCriterio->porcentaje,
                            'nota' => $tareaEstudiante->nota,
                        ];
                    }
                }
            }
            $notasPorCategoria = [];
            $notasPorCriterio = [];
            foreach ($todasLasTareas as $tarea) {
                $categoriaId = $tarea['categoria'];
                $criterioId = $tarea['criterio'];
                $nota = $tarea['nota'];
                if ($categoriaId !== null) {
                    if (!isset($notasPorCategoria[$categoriaId]['suma'])) {
                        $notasPorCategoria[$categoriaId]['suma'] = 0;
                        $notasPorCategoria[$categoriaId]['porcentaje'] = $tarea['porcentajeCategoria'];
                    }
                    $notasPorCategoria[$categoriaId]['suma'] += $nota;
                } elseif ($criterioId !== null) {
                    if (!isset($notasPorCriterio[$criterioId]['suma'])) {
                        $notasPorCriterio[$criterioId]['suma'] = 0;
                        $notasPorCriterio[$criterioId]['porcentaje'] = $tarea['porcentajeCriterio'];
                    }
                    $notasPorCriterio[$criterioId]['suma'] += $nota;
                }
            }

            foreach ($notasPorCategoria as $categoriaId => $data) {
                $porcentajeCategoria = $data['porcentaje'];
                $totalTrabajosCat = $this->obtenerTotalTrabajosPorCategoria($categoriaId, $idCurso);
                $notasPorCategoria[$categoriaId]['notaFinal'] = ($data['suma'] / $totalTrabajosCat) * ($porcentajeCategoria / 100);
            }
            foreach ($notasPorCriterio as $criterioId => $data) {
                $porcentajeCriterio = $data['porcentaje'];
                $totalTrabajosCrit = $this->obtenerTotalTrabajosPorCriterio($criterioId, $idCurso);
                $notasPorCriterio[$criterioId]['notaFinal'] = ($data['suma'] / $totalTrabajosCrit) * ($porcentajeCriterio / 100);
            }

            $notasFinalesPorCriterio = [];
            foreach ($notasPorCategoria as $categoriaId => $data) {
                $criterioId = $this->obtenerCriterioParaCategoria($categoriaId);
                if (!isset($notasFinalesPorCriterio[$criterioId])) {
                    $notasFinalesPorCriterio[$criterioId] = ['suma' => 0, 'totalCategorias' => 0];
                }
                $notasFinalesPorCriterio[$criterioId]['suma'] += $data['notaFinal'];
                $notasFinalesPorCriterio[$criterioId]['totalCategorias']++;
            }

            $sumarTotal = 0;

            foreach ($notasPorCriterio as $criterioId => $dataCriterio) {
                $sumarTotal += $dataCriterio['notaFinal'];
            }

            foreach ($notasFinalesPorCriterio as $criterioId => $datosCriterio) {
                $sumaCriterio = $datosCriterio['suma'];
                $sumarTotal += $sumaCriterio;
            }

            $cantidadEvaluaciones = Trabajo::where('evaluacion', true)->count();
            $cantidadNoEvaluaciones = Trabajo::where('evaluacion', false)->count();
            $criterio = CategoriaCriterio::where('asistencia', 1)->first();
            if ($criterio) {
                $notaAsistencia = $this->calcularNotAsistencia($idEst, $idCurso, $criterio->porcentaje);
            }
            Calificacion::updateOrCreate(
                ['estudiante_id' => $idEst, 'curso_id' => $idCurso],
                [
                    'num_trabajos' => $cantidadNoEvaluaciones,
                    'num_evaluaciones' => $cantidadEvaluaciones,
                    'calificacion' => $sumarTotal + $notaAsistencia,
                ]
            );
        }
    }
    
    public function obtenerCriterioParaCategoria($categoriaId) {
        $categoria = CategoriaCriterio::find($categoriaId);
    
        if ($categoria) {
            return $categoria->criterio_id;
        }
    
        return null;
    }

    function obtenerTotalTrabajosPorCategoria($categoriaId, $cursoId) {
        // Encuentra la categoría por ID
        $categoria = CategoriaCriterio::find($categoriaId);
        
        if ($categoria) {
            // Filtra los trabajos relacionados con la categoría y el curso
            $trabajos = $categoria->catCritTrabajos()->whereHas('trabajo', function($query) use ($cursoId) {
                $query->where('curso_id', $cursoId);
            })->get();
            
            // Devuelve la cantidad de trabajos encontrados
            return $trabajos->count();
        }    
        
        return 0;
    }
    function obtenerTotalTrabajosPorCriterio($criterioId, $cursoId) {
        // Encuentra el criterio por ID
        $criterio = Criterio::find($criterioId);
    
        if ($criterio) {
            // Filtra los trabajos relacionados con el criterio y el curso
            $trabajos = $criterio->trabajos()->where('curso_id', $cursoId)->get();
            
            // Devuelve la cantidad de trabajos encontrados
            return $trabajos->count();
        }
    
        return 0;
    }
    
    public function descargarNotasFinalesEXCEL() {
        try {
            $curso = CursoHabilitado::find($this->idCurso);
            $notasFinales = Calificacion::where('curso_id', $this->idCurso)->get();
            Carbon::setLocale('es');
            $fechaActual = Carbon::now();
            $data = [
                'titulo' => 'REPORTE DE CALIFICACIONES',
                'fecha' => $fechaActual->format('d F Y'),
                'curso' => $curso,
                'notas' => $notasFinales,
                'i' => 1,
            ];
            return Excel::download(new CalificacionesExport($data), 'archivo_excel.xlsx');
        } catch (\Throwable $th) {
            session()->flash('error', 'Ocurrió un error al realizar la descarga: ' . $th->getMessage());
        }
    }
    public function descargarNotasFinalesPDF() {
        try {
            $curso = CursoHabilitado::find($this->idCurso);
            $notasFinales = Calificacion::where('curso_id', $this->idCurso)->get();
            Carbon::setLocale('es');
            $fechaActual = Carbon::now();
            $data = [
                'titulo' => 'REPORTE DE CALIFICACIONES',
                'fecha' => $fechaActual->format('d F Y'),
                'curso' => $curso,
                'notas' => $notasFinales,
                'i' => 1,
            ];
    
            $pdfContent = Pdf::loadView('pdf.calificaciones', $data);
    
            return response()->streamDownload(
                function () use ($pdfContent) {
                    echo $pdfContent->stream();
                },
                'archivo_pdf.pdf'
            );
    
        } catch (\Throwable $th) {
            session()->flash('error', 'Ocurrió un error al realizar la descarga: ' . $th->getMessage());
        }
    }    
}
