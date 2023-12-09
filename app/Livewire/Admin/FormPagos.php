<?php

namespace App\Livewire\Admin;

use App\Models\MetodoPago;
use Livewire\Component;

class FormPagos extends Component
{
    public $idMetodoPago;
    public function render()
    {
        $metodos = MetodoPago::all();
        return view('livewire.admin.form-pagos', compact('metodos'))
        ->extends('layouts.app')->section('content');
    }
}
