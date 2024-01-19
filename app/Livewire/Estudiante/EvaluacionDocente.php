<?php

namespace App\Livewire\Estudiante;

use App\Models\CursoHabilitado;
use App\Models\EvaluacionHabilitada;
use Livewire\Component;

class EvaluacionDocente extends Component
{
    public CursoHabilitado $curso;
    public $estado = false;
    public $preguntas, $evaluacion;

    public function mount($id) {
        $this->curso = CursoHabilitado::find($id);
        $evaluacion = EvaluacionHabilitada::where('materia_id', $id)->exists();
        if ($evaluacion) {
            $this->estado = true;
            $habilitado = EvaluacionHabilitada::where('materia_id', $id)->first();
            $this->showPreguntas($habilitado);
        }
    }
    public function showPreguntas($habilitado) {
        $this->preguntas = $habilitado->evaluacionDocente->preguntas;
    }
    public function render()
    {
        return view('livewire.estudiante.evaluacion-docente');
    }
}
