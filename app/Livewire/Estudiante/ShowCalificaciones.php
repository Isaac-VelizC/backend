<?php

namespace App\Livewire\Estudiante;

use App\Models\Calificacion;
use App\Models\Programacion;
use Livewire\Component;

class ShowCalificaciones extends Component
{
    public $notas = [];

    public function mount($id) {
        $materias = Programacion::where('estudiante_id', $id)->get();
    
        foreach ($materias as $materia) {
            $calificacion = Calificacion::where('estudiante_id', $id)->where('curso_id', $materia->curso_id)->first();
    
            if ($calificacion) {
                $this->notas[] = [
                    'materia' => $materia->cursoDocente->curso->nombre,
                    'calificacion' => $calificacion->calificacion,
                ];
            }
        }
    }
    
    public function render()
    {
        return view('livewire.estudiante.show-calificaciones');
    }
}
