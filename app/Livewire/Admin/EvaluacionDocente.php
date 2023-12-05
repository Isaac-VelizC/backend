<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class EvaluacionDocente extends Component
{
    public function render()
    {
        return view('livewire.admin.evaluacion-docente')->extends('layouts.app')
        ->section('content');
    }
}
