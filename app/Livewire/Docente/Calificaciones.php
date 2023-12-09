<?php

namespace App\Livewire\Docente;

use App\Models\CursoHabilitado;
use App\Models\Trabajo;
use Livewire\Component;

class Calificaciones extends Component
{
    public $estudiantes;
    public CursoHabilitado $materia;
    public $trabajos;
    public function mount($id) {
        $curso = CursoHabilitado::with('inscripciones.estudiante')->find($id);
        $this->estudiantes = $curso->inscripciones->pluck('estudiante');
        $this->trabajos = Trabajo::where('curso_id', $curso->id)->get();

    }
    public function render()
    {
        return view('livewire.docente.calificaciones');
    }
}
