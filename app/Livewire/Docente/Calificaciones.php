<?php

namespace App\Livewire\Docente;

use App\Models\Calificacion;
use App\Models\CursoHabilitado;
use App\Models\Trabajo;
use App\Models\TrabajoEstudiante;
use Livewire\Component;

class Calificaciones extends Component
{
    public $estudiantes, $idCurso;
    public CursoHabilitado $materia;
    public $trabajos, $notas;
    public function mount($id) {
        $this->idCurso = $id;
        $curso = CursoHabilitado::with('inscripciones.estudiante')->find($id);
        $this->estudiantes = $curso->inscripciones->pluck('estudiante');
        $this->trabajos = Trabajo::where('curso_id', $curso->id)->where('estado', '!=', 'Borrador')->get();
        $this->cargarNotas();
    }
    public function cargarNotas() {
        $this->notas = [];
        $calificacionesCurso = Calificacion::where('curso_id', $this->idCurso)->get();

        foreach ($this->estudiantes as $est) {
            $this->notas[$est->id] = [];

            foreach ($this->trabajos as $tra) {
                $nota = TrabajoEstudiante::where([
                    'estudiante_id' => $est->id,
                    'trabajo_id' => $tra->id,
                ])->value('nota');

                $this->notas[$est->id][$tra->id] = $nota;
            }
            // Agrega la calificación final
            $calificacionEstudiante = $calificacionesCurso->firstWhere('estudiante_id', $est->id);
            $this->notas[$est->id]['notaFinal'] = $calificacionEstudiante ? $calificacionEstudiante->calificacion : 'N/A';
        }

    }
    public function render()
    {
        return view('livewire.docente.calificaciones');
    }
    
}
