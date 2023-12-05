<?php

namespace App\Livewire\Docente;

use App\Models\CursoHabilitado;
use Livewire\Component;

class Calificaciones extends Component
{
    public $estudiantes;
    public CursoHabilitado $materia;
    public function mount($id) {
        $curso = CursoHabilitado::with('inscripciones.estudiante')->find($id);
        $this->estudiantes = $curso->inscripciones->pluck('estudiante');
    }
    public function render()
    {
        return view('livewire.docente.calificaciones');
    }
}
