<?php

namespace App\Livewire\Admin;

use App\Models\HistorialInventario as ModelsHistorialInventario;
use Livewire\Component;

class HistorialInventario extends Component
{
    public $historial;
    public function mount() {
        $this->historial = ModelsHistorialInventario::orderBy('fecha', 'asc')->get();
    }
    public function render()
    {
        return view('livewire.admin.historial-inventario')->extends('layouts.app')->section('content');
    }
}
