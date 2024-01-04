<?php

namespace App\Livewire\Admin;

use App\Models\CursoHabilitado;
use App\Models\EvaluacionDocente;
use App\Models\EvaluacionHabilitada;
use Livewire\Component;

class MateriaEvaluacionDocente extends Component
{
    public $materias;
    public $selectAll = false, $materiasSeleccionadas = [];

    public function mount() {
        $this->materias = CursoHabilitado::where('estado', true)->get();
        $this->materiasSeleccionadas();
    }

    public function materiasSeleccionadas() {
        $materiasHabilitadas = EvaluacionHabilitada::pluck('materia_id')->toArray();
        $this->materiasSeleccionadas = $materiasHabilitadas;
    }
    
    public function render()
    {
        return view('livewire.admin.materia-evaluacion-docente')->extends('layouts.app')
        ->section('content');
    }

    public function habilitarEvaluacion($id) {
        try {
            $registro = EvaluacionDocente::first();
            if ($id && $registro) {
                EvaluacionHabilitada::create([
                    'materia_id' => $id,
                    'eval_docente_id' => $registro->id,
                ]);
                session()->flash('message', 'Evaluación al docente Hailitada en la materia.');
                //$this->cancelar();
            }
            else {
                session()->flash('error', 'Ocurrio un ploblema al habilitar la evalución al docente a la materia.');
                //$this->cancelar();
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al realizar la operación: ' . $e->getMessage());
        }
    }
    public function BorrarEvaluacion($id) {
        try {
            EvaluacionHabilitada::where('materia_id', $id)->delete();
            session()->flash('message', 'Se quitó la evaluación al docente a la materia.');
            $this->materiasSeleccionadas();
        } catch (\Exception $e) {
            session()->flash('error', 'Error al realizar la operación: ' . $e->getMessage());
        }
    }    
}
