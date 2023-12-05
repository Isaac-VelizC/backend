<?php

namespace App\Livewire\Docente\Components;

use App\Models\CursoHabilitado;
use App\Models\Pregunta;
use App\Models\Tema;
use App\Models\TipoTrabajo;
use Carbon\Carbon;
use Livewire\Component;

class NewPregunta extends Component
{
    public $tema, $idCurso, $idTarea, $idFiles, $temasCurso, $tipoTrabajo, $tareas, $preguntas;
    public CursoHabilitado $materia;
    public $pregunta = ['pregunta' => '', 'tema' => '', 'limite' => '', 'con_nota' => false, 'nota' => '100'];
    public $files = [], $filesTarea;
    public function mount($id) {
        $this->idCurso = $id;
        $this->materia = CursoHabilitado::findOrFail($id);
        $this->temasCurso = Tema::where('curso_id', $id)->get();
        $this->tipoTrabajo = TipoTrabajo::all();
    }
    public function render()
    {
        return view('livewire.docente.components.new-pregunta')->extends('layouts.app')
        ->section('content'); 
    }
    public function guardarPregunta() {

        if ($this->pregunta['nota'] === '' || (floatval($this->pregunta['nota']) === 0 || !ctype_digit((string)$this->pregunta['nota']))) {
            $this->pregunta['nota'] = '100';
        }
        $this->validate([
            'pregunta.pregunta' => 'required|string|max:255',
            'pregunta.tema' => 'nullable|numeric',
            'pregunta.limite' => 'nullable|date',
            'pregunta.con_nota' => 'required|boolean',
            'pregunta.nota' => $this->pregunta['con_nota'] ? 'required|numeric' : 'nullable|numeric',
        ]);
        Pregunta::create([
            'pregunta' => $this->pregunta['pregunta'],
            'curso_id' => $this->idCurso,
            'con_nota' => $this->pregunta['con_nota'],
            'nota' => $this->pregunta['nota'],
            'inicio' => Carbon::now(),
            'limite' => $this->pregunta['limite'] ?: null,
            'tema_id' => $this->pregunta['tema'] ?: null,
            'estado' => 'Publicado',
        ])->save();
        session()->flash('message', 'La pregunta se realizo con éxito');
        // Redirigir a la página anterior
        $this->dispatch('redirectBack');
    }
}
