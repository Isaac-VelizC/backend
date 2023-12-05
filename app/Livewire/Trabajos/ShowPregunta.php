<?php

namespace App\Livewire\Trabajos;

use App\Models\CursoHabilitado;
use App\Models\Pregunta;
use App\Models\PreguntaEstudiante;
use Livewire\Component;

class ShowPregunta extends Component
{
    public $preguntaId, $num = 1;
    public Pregunta $pregunta;
    public $respuestas, $estudiantes;
    public function mount($id) {
        $this->preguntaId = $id;
        $this->pregunta = Pregunta::find($id);
        $this->respuestas = PreguntaEstudiante::where('pregunta_id', $id)->get();
        $curso = CursoHabilitado::with('inscripciones.estudiante')->find($this->pregunta->curso->id);
        $this->estudiantes = $curso->inscripciones->pluck('estudiante');
    }
    public function render()
    {
        return view('livewire.trabajos.show-pregunta')->extends('layouts.app')
        ->section('content');
    }
}
