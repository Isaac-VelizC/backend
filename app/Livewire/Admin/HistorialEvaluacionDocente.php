<?php

namespace App\Livewire\Admin;

use App\Models\EvaluacionHabilitada;
use Livewire\Component;

class HistorialEvaluacionDocente extends Component
{
    public $materiasHabilitados;
    public function mount() {
        $this->materiasHabilitados = EvaluacionHabilitada::all();
    }
    public function render()
    {
        return view('livewire.admin.historial-evaluacion-docente')->extends('layouts.app')->section('content');
    }
}
