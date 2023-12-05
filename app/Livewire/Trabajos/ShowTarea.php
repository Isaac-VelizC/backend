<?php

namespace App\Livewire\Trabajos;

use App\Models\CursoHabilitado;
use App\Models\DocumentoDocente;
use App\Models\DocumentoEstudiante;
use App\Models\Trabajo;
use App\Models\TrabajoEstudiante;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ShowTarea extends Component
{
    public $tareaId, $num = 1, $fechaActual, $estudiantesConTareas, $trabajosSubidosCali, $nota;
    public Trabajo $tarea;
    public $entregas, $estudiantes, $filesTarea;
    public $filesSubidos, $trabajoSubido;
    public $guardando = false;
    public function mount($id) {
        $this->tareaId = $id;
        $this->fechaActual = Carbon::now();
        $this->tarea = Trabajo::find($id);
        $this->entregas = TrabajoEstudiante::where('trabajo_id', $id)->get();
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
    public function obtenerEstudiantesConTareas()
    {
        return $this->estudiantes->map(function ($estud) {
            $haEnviadoTarea = TrabajoEstudiante::where([
                'estudiante_id' => $estud->id,
                'trabajo_id' => $this->tareaId
            ])->exists();

            return [
                'estudiante' => $estud,
                'haEnviadoTarea' => $haEnviadoTarea,
            ];
        });
    }

    public function VerTarea($id) {
        $subidoPararRevisar = TrabajoEstudiante::where([
            'estudiante_id' => $id, 
            'trabajo_id' => $this->tareaId
        ])->first();
        $this->trabajosSubidosCali = DocumentoEstudiante::where('entrega_id', $subidoPararRevisar->id)->get();
    }

    public function calificarTarea($id)
    {
        $this->guardando = true;

        // Busca la tarea del estudiante
        $notaGuardar = TrabajoEstudiante::where([
            'estudiante_id' => $id,
            'trabajo_id' => $this->tareaId,
        ])->first();

        // Verifica si se encontró la tarea antes de intentar actualizar
        if ($notaGuardar) {
            // Actualiza la nota en la base de datos
            $notaGuardar->update(['nota' => $this->nota]);
        }

        // Reinicia la variable $nota y el estado de guardando
        $this->nota = 0;
        $this->guardando = false;
    }


}
