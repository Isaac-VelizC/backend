<?php

namespace App\Livewire\Estudiante;

use App\Http\Controllers\InfoController;
use App\Models\Curso;
use App\Models\CursoHabilitado;
use App\Models\Estudiante;
use App\Models\Programacion;
use App\Models\Semestre;
use Carbon\Carbon;
use Livewire\Component;

class MateriaSemestre extends Component
{
    public $semestres, $materias, $idEst;
    public Estudiante $estudiante;
    public $semestreActivo;
    public $CursoHabilitado = [], $curso;
    public function mount($id) {
        $this->idEst = $id;
        $this->estudiante = Estudiante::find($id);
        $this->semestres = Semestre::all();
        $primerSemetre = Semestre::all()->first();
        $this->semestreActivo = $primerSemetre->id;
        $this->materias = Curso::where('semestre_id', $primerSemetre->id)->get();
    }
    public function render()
    {
        return view('livewire.estudiante.materia-semestre');
    }
    public function cursosSemestre($id) {
        $this->materias = Curso::where('semestre_id', $id)->get();
        $this->semestreActivo = $id;
    }
    public function showMateria($id) {
        try {
            $this->curso = Curso::find($id);
            $this->CursoHabilitado = CursoHabilitado::where('curso_id', $this->curso->id)->where('estado', true)->get();
            $this->dispatch('materiaShown', $id);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al obtener los datos: ' . $e->getMessage());
        }
    }
    public function programarCurso($id) {
        try {
            Programacion::create([
                'estudiante_id' => $this->idEst,
                'responsable_id' => auth()->user()->id,
                'curso_id' => $id,
                'fecha' => Carbon::now()
            ]);
    
            $this->notificarProgramacion($this->idEst, $id);
            $this->curso;
            $this->CursoHabilitado = [];
    
            session()->flash('success', 'Materia programada');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al programar la materia: ' . $e->getMessage());
        }
    }
    
    public function desprogramarCurso($id) {
        Programacion::find($id)->delete();
        $this->curso;
        $this->CursoHabilitado = [];
        session()->flash('success', 'Materia desprogramada');
    }
    public function notificarProgramacion($estudianteId, $cursoId) {
        $curso = CursoHabilitado::find($cursoId);
        $message = "Se le programó a la materia " . $curso->curso->nombre;
        
        $numeroTelefono = $this->obtenerNumeroTelefonoEstudiante($estudianteId);
        InfoController::notificacionNotaTarea($numeroTelefono, $message);
    }
    protected function obtenerNumeroTelefonoEstudiante($estudianteId) {
        $estudiante = Estudiante::find($estudianteId);
        return optional($estudiante->persona->numTelefono)->numero;
    }
    
}
