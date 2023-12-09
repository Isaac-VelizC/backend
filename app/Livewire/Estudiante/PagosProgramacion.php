<?php

namespace App\Livewire\Estudiante;

use App\Models\Estudiante;
use App\Models\FormaPago;
use App\Models\MetodoPago;
use App\Models\Pagos;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PagosProgramacion extends Component
{
    public Estudiante $estudiante;
    public $formaPagos, $idMetodo, $pagos;
    public $pagosEdit = ['formaPago' => '', 'fecha' => '', 'monto' => 0, 'descripcion' => ''];
    public function mount($id) {
        $this->estudiante = Estudiante::find($id);
        $this->formaPagos = FormaPago::all();
        $this->pagos = Pagos::where('est_id', $id)->get();
    }
    public function render()
    {
        $metodos = MetodoPago::all();
        return view('livewire.estudiante.pagos-programacion', compact('metodos'));
    }
    public function formPago($id) {
        try {
            $metodo = MetodoPago::find($id);
            $this->idMetodo = $id;
            $this->pagosEdit['monto'] = $metodo->monto;
            $this->pagosEdit['fecha'] = now()->toDateString();
            $this->dispatch('modalPago', $id);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al obtener los datos: ' . $e->getMessage());
        }
    }
    public function guardarPago() {
        try {
            $this->validate([
                'pagosEdit.formaPago' => 'required',
                'idMetodo' => 'required',
                'pagosEdit.fecha' => 'required|date',
                'pagosEdit.monto' => 'required|numeric',
                'pagosEdit.descripcion' => 'nullable|string',
            ]);
            Pagos::create([
                'responsable_id' => Auth::id(),
                'est_id' => $this->estudiante->id,
                'forma_id' => $this->pagosEdit['formaPago'],
                'metodo_id' => $this->idMetodo,
                'fecha' => $this->pagosEdit['fecha'],
                'monto' => $this->pagosEdit['monto'],
                'comentario' => $this->pagosEdit['descripcion']
            ]);
            $this->resetForm();
            session()->flash('success', 'Pago registrado exitosamente.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al registrar pago: ' . $th->getMessage());
        }
    }
    public function guardarImprimir() {
        $this->guardarPago();
        return redirect()->route('admin.pago.guardar.imprimir');
    }
    public function resetForm() {
        $this->pagosEdit = ['formaPago' => '', 'fecha' => '', 'monto' => 0, 'descripcion' => ''];
        $this->idMetodo = '';
    }
}
