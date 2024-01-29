<?php

namespace App\Livewire\Estudiante;

use App\Models\CursoHabilitado;
use App\Models\EvalRespuestas;
use App\Models\EvaluacionHabilitada;
use App\Models\Persona;
use App\Models\RespuestaEstudiante;
use Livewire\Component;

class EvaluacionDocente extends Component
{
    public CursoHabilitado $curso;
    public $estado = false, $stadoEvaluacion = false;
    public $preguntas, $evaluacion, $evalId, $comentario;
    public $respuestasEstudiante;

    public function mount($id) {
        $idEstudiante = auth()->user()->persona->estudiante->id;
        $this->curso = CursoHabilitado::find($id);
    
        $evaluacion = EvaluacionHabilitada::where('materia_id', $id)->first();
        if ($evaluacion) {
            $this->estado = true;
            $this->evalId = $evaluacion->evaluacionDocente->id;
            $this->showPreguntas($evaluacion);
        }
    
        $evaluado = RespuestaEstudiante::where('estudiante_id', $idEstudiante)
            ->where('materia_id', $id)
            ->with('evalRespuestas')
            ->first();
    
        if ($evaluado) {
            $this->comentario = $evaluado->cometario;
            $this->stadoEvaluacion = true;
            $this->respuestasEstudiante = $evaluado->evalRespuestas->pluck('texto', 'pregunta_id')->all();
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
