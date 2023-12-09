<?php

namespace App\Livewire\Estudiante;

use App\Models\Estudiante;
use App\Models\MetodoPago;
use Livewire\Component;

class PagosProgramacion extends Component
{
    public Estudiante $estudiante;
    public function mount($id) {
        $this->estudiante = Estudiante::find($id);
    }
    public function render()
    {
        $metodos = MetodoPago::all();
        return view('livewire.estudiante.pagos-programacion', compact('metodos'));
    }
    public function guardarPago() {
        
    }
    public function guardarImprimir() {
        //$this->guardarPago();
        return redirect()->route('admin.pago.guardar.imprimir');
    }
}
