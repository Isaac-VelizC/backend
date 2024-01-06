<?php

namespace App\Livewire\Trabajos;

use App\Http\Controllers\InfoController;
use App\Models\Calificacion;
use App\Models\CatCritTrabajo;
use App\Models\CategoriaCriterio;
use App\Models\Criterio;
use App\Models\CursoHabilitado;
use App\Models\DocumentoDocente;
use App\Models\DocumentoEstudiante;
use App\Models\Estudiante;
use App\Models\Ingrediente;
use App\Models\Trabajo;
use App\Models\TrabajoEstudiante;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ShowTarea extends Component
{
    public $tareaId, $num = 1, $fechaActual, $estudiantesConTareas, $trabajosSubidosCali, $tareaDelEstudiante = '';
    public Trabajo $tarea;
    public $ingredientesTarea;
    public $entregas, $calificadas, $estudiantes, $filesTarea;
    public $filesSubidos, $trabajoSubido = [];
    public function mount($id) {
        $this->tareaId = $id;
        $this->fechaActual = Carbon::now();
        $this->tarea = Trabajo::find($id);
        $ingredientesIds = json_decode($this->tarea->ingredientes);
        if ($ingredientesIds) {
            $this->ingredientesTarea = Ingrediente::whereIn('id', $ingredientesIds)->pluck('nombre')->toArray();
        } else {
            $this->ingredientesTarea = [];
        }
        $this->entregas = TrabajoEstudiante::where('trabajo_id', $id)->count();
        $this->calificadas = TrabajoEstudiante::where('trabajo_id', $id)->where('nota', '<>', 0.00)->count();
        $this->filesTarea = DocumentoDocente::where('tarea_id', $id)->get();
        $curso = CursoHabilitado::with('inscripciones.estudiante')->find($this->tarea->curso->id);
        $this->estudiantes = $curso->inscripciones->pluck('estudiante');
        if (auth()->user()->hasRole('Estudiante')) {
            $this->verTareaEstudiante();
        } else {
            $this->estudiantesConTareas = $this->obtenerEstudiantesConTareas();
        }
    }
    public function render()
    {
        return view('livewire.trabajos.show-tarea')->extends('layouts.app')
        ->section('content');
    }
    public function verTareaEstudiante() {
        $trabajo = TrabajoEstudiante::where([
            'estudiante_id' => auth()->user()->persona->estudiante->id, 
            'trabajo_id' => $this->tareaId
        ])->first();
        if ($trabajo) {
            $this->trabajoSubido = $trabajo;
            $this->filesSubidos = DocumentoEstudiante::where('entrega_id', $trabajo->id)->get();
        } else {
            $fecha = $this->tarea->fin ? 'hasta el ' .$this->tarea->fin : ' sin fecha limite' ;
            session()->flash('success', 'Tiene una tarea pendiente '. $fecha );
        }
    }
    public function borrarTareaSubido($id) {
        $tarea = TrabajoEstudiante::find($id);
        $docs = DocumentoEstudiante::where('entrega_id', $tarea->id)->get();
        if ($docs->isNotEmpty()) {
            foreach ($docs as $doc) {
                if (Storage::exists($doc->url)) {
                    Storage::delete($doc->url);
                }
                $doc->delete();
            }
        }
        $tarea->delete();
        $this->trabajoSubido = null;
    }
    public function editarTareasSubido($id) {
        $trabajo = TrabajoEstudiante::find($id);
        return redirect()->route('estudiante.subir.tarea', ['id' => $trabajo->trabajo_id, 'edit' => true]);
    }
    public function obtenerEstudiantesConTareas() {
        return $this->estudiantes->map(function ($estud) {
            $trabajo = TrabajoEstudiante::where([
                'estudiante_id' => $estud->id,
                'trabajo_id' => $this->tareaId
            ])->first();
    
            $haEnviadoTarea = $trabajo !== null;
            if ($haEnviadoTarea) {
                $this->trabajoSubido[$estud->id] = $trabajo->nota;
            }
    
            return [
                'estudiante' => $estud,
                'haEnviadoTarea' => $haEnviadoTarea,
            ];
        });
    }
    public function VerTarea($id) {
        $estudiante = Estudiante::find($id);
        $this->tareaDelEstudiante = 'Estudiante '.$estudiante->persona->nombre . ' ' . $estudiante->persona->ap_paterno . ' ' . $estudiante->persona->ap_materno;
        $subidoPararRevisar = TrabajoEstudiante::where([
            'estudiante_id' => $id, 
            'trabajo_id' => $this->tareaId
        ])->first();
        if ($subidoPararRevisar) {
            $this->trabajosSubidosCali = DocumentoEstudiante::where('entrega_id', $subidoPararRevisar->id)->get();
        } else {
            session()->flash('error', 'No subio ningun trabajo él/la estudiante '.$this->tareaDelEstudiante);
            $this->trabajosSubidosCali = '';
        }
    }
    public function calificarTarea($id) {
        try {
            $notaEstudiante = $this->trabajoSubido[$id];
            if ($notaEstudiante !== null) {
                if (!preg_match('/^\d+(\.\d{0,2})?$/', $notaEstudiante)) {
                    $this->addError("errorNota", 'Solo se permiten números o decimales con hasta dos lugares decimales.');
                    return;
                }
                $notaGuardar = TrabajoEstudiante::where([
                    'estudiante_id' => $id,
                    'trabajo_id' => $this->tareaId,
                ])->first();
                if ($notaGuardar) {
                    $notaGuardar->update(['nota' => $notaEstudiante, 'estado' => 'Calificado']);
                    $this->notificar($id, $notaGuardar->trabajo->titulo, $notaEstudiante);
                    $this->calcularNotaTotal($id, $this->tarea->curso->id);
                }
            }
        } catch (\Throwable $th) {
            $this->addError("errorNota", 'Error al intentar calificar la tarea.'. $th);
        }
    }
    public function calcularNotaTotal($idEst, $idCurso) {
        $tareasEstudiante = TrabajoEstudiante::where('estudiante_id', $idEst)
            ->whereHas('trabajo', function ($query) use ($idCurso) {
                $query->where('curso_id', $idCurso);
            })->get();
        $todasLasTareas = [];
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
            $totalTrabajosCat = $this->obtenerTotalTrabajosPorCategoria($categoriaId);
            $notasPorCategoria[$categoriaId]['notaFinal'] = ($data['suma'] / $totalTrabajosCat) * ($porcentajeCategoria / 100);
        }
        foreach ($notasPorCriterio as $criterioId => $data) {
            $porcentajeCriterio = $data['porcentaje'];
            $totalTrabajosCrit = $this->obtenerTotalTrabajosPorCriterio($criterioId);
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
        Calificacion::updateOrCreate(
            ['estudiante_id' => $idEst, 'curso_id' => $idCurso],
            [
                'num_trabajos' => $cantidadNoEvaluaciones,
                'num_evaluaciones' => $cantidadEvaluaciones,
                'calificacion' => $sumarTotal,
            ]
        );
    }
    public function notificar($id, $titulo, $nota) {
        $estudiante = Estudiante::find($id);
        $num = $estudiante->persona->numTelefono->numero;
        $message = "Se le califico al Trabajo que enviaste ". $titulo . ", con una nota de " . $nota;
        if ($num) {
            InfoController::notificacionNotaTarea($num, $message);
        }
    }
    
    public function obtenerCriterioParaCategoria($categoriaId) {
        $categoria = CategoriaCriterio::find($categoriaId);
    
        if ($categoria) {
            return $categoria->criterio_id;
        }
    
        return null;
    }

    function obtenerTotalTrabajosPorCategoria($categoriaId) {
        $categoria = CategoriaCriterio::find($categoriaId);
        if ($categoria) {
            $trabajos = $categoria->catCritTrabajos;
            return $trabajos->count();
        }    
        return 0;
    }
    function obtenerTotalTrabajosPorCriterio($criterioId) {
        $criterio = Criterio::find($criterioId);
        if ($criterio) {
            $trabajos = $criterio->trabajos;
            return $trabajos->count();
        }
        return 0;
    }
    

}
