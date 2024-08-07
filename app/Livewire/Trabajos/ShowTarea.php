<?php

namespace App\Livewire\Trabajos;

use App\Http\Controllers\InfoController;
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
    public $ingredientesTarea, $textTarea = '';
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
        } elseif($this->tarea->fin >= now()) {
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
        $this->tareaDelEstudiante = 'Estudiante: '.$estudiante->persona->nombre . ' ' . $estudiante->persona->ap_paterno . ' ' . $estudiante->persona->ap_materno;
        $subidoPararRevisar = TrabajoEstudiante::where([
            'estudiante_id' => $id, 
            'trabajo_id' => $this->tareaId
        ])->first();
        if ($subidoPararRevisar) {
            $this->trabajosSubidosCali = DocumentoEstudiante::where('entrega_id', $subidoPararRevisar->id)->get();
            $this->textTarea = $subidoPararRevisar->descripcion;
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
                    $this->addError("errorNota", 'Solo se permiten números o decimales con hasta dos lugares decimales. 0.00');
                    return;
                }
                if ($notaEstudiante > 100) {
                    $this->addError("errorNota", 'No se puede poner una nota mas de 100');
                    return;
                }
                $notaGuardar = TrabajoEstudiante::where([
                    'estudiante_id' => $id,
                    'trabajo_id' => $this->tareaId,
                ])->first();
                
                if ($notaGuardar) {
                    $notaGuardar->update(['nota' => $notaEstudiante, 'estado' => 'Calificado']);
                    $this->notificar($id, $notaGuardar->trabajo->titulo, $notaEstudiante);
                } else {
                    $this->addError("errorNota", 'Error: No se encontro el trabajo del estudiante');
                }
            }
        } catch (\Throwable $th) {
            $this->addError("errorNota", 'Error al intentar calificar la tarea: '. $th->getMessage());
        }
    }
    public function notificar($id, $titulo, $nota) {
        $estudiante = Estudiante::find($id);
        $num = $estudiante->persona->numero;
        $message = "Se le califico al Trabajo que enviaste ". $titulo . ", con una nota de " . $nota;
        if ($num) {
            InfoController::notificacionNotaTarea($num, $message);
        }
    }
}
