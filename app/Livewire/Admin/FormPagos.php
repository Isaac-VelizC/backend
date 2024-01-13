<?php

namespace App\Livewire\Admin;

use App\Models\FormaPago;
use App\Models\MetodoPago;
use App\Models\Pagos;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormPagos extends Component
{
    public $idMetodoPago, $formaPagos;
    public $datosPagos = ['formaPago' => '', 'estudiante' => '', 'fecha' => '', 'monto' => '', 'descripcion' => ''];
    
    public function mount() {
        $this->formaPagos = FormaPago::all();
        $this->datosPagos['fecha'] = now()->toDateString();
    }
    
    public function render()
    {
        return view('livewire.admin.form-pagos')
        ->extends('layouts.app')->section('content');
    }
    public function guardarPago() {
        try {
            $this->validate([
                'datosPagos.formaPago' => 'required',
                'datosPagos.estudiante' => 'required',
                'datosPagos.fecha' => 'required|date',
                'datosPagos.monto' => 'required|numeric',
                'datosPagos.descripcion' => 'nullable|string',
            ]);
            Pagos::create([
                'responsable_id' => Auth::id(),
                'est_id' => $this->datosPagos['estudiante'],
                'forma_id' => $this->datosPagos['formaPago'],
                'fecha' => $this->datosPagos['fecha'],
                'monto' => $this->datosPagos['monto'],
                'comentario' => $this->datosPagos['descripcion'],
            ]);
            $this->resetForm();
            session()->flash('success', 'Pago registrado exitosamente.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al registrar pago: ' . $th->getMessage());
        }
    }
    public function resetForm() {
        $this->datosPagos = ['formaPago' => '', 'estudiante' => '', 'fecha' => '', 'monto' => '', 'descripcion' => ''];
    }
}
