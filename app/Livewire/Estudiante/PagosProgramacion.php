<?php

namespace App\Livewire\Estudiante;

use App\Models\Estudiante;
use App\Models\FormaPago;
use App\Models\MetodoPago;
use App\Models\PagoMensual;
use App\Models\Pagos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PagosProgramacion extends Component
{
    public Estudiante $estudiante;
    public $formaPagos, $idMetodo, $pagos, $tituloFormPago, $idMensual;
    public $pagosEdit = ['formaPago' => '', 'fecha' => '', 'monto' => 0, 'descripcion' => ''];
    public $pagosMensuales = [];
    public function mount($id) {
        $this->estudiante = Estudiante::find($id);
        $this->formaPagos = FormaPago::all();
        $this->llamadoPrincipal();
    }
    public function llamadoPrincipal() {
        $this->pagos = Pagos::where('est_id', $this->estudiante->id)->get();
        $this->pagosMensualesPendientes();
    }
    public function render() {
        return view('livewire.estudiante.pagos-programacion');
    }
    public function pagosMensualesPendientes() {
        try {
            setlocale(LC_TIME, 'es_ES.UTF-8', 'Spanish_Spain.1252');
            $pagosPendientes = PagoMensual::where('estudiante_id', $this->estudiante->id)
                ->where('pagado', false)
                ->get();
            $metodoPago = MetodoPago::find(1);
            foreach ($pagosPendientes as $pagoPendiente) {
                $fecha = Carbon::create(null, $pagoPendiente->mes, 1);
                $this->pagosMensuales[] = [
                    'id' => $pagoPendiente->id,
                    'mes' => strftime('%B', $fecha->timestamp),
                    'anio' => $pagoPendiente->anio,
                    'monto' => $metodoPago->monto,
                    'idMetodo' => $metodoPago->id,
                ];
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al obtener los datos de pagos pendientes: ' . $e->getMessage());
        }
    }
    public function formPago($id, $mes, $nombre) {
        try {
            $mesual = PagoMensual::find($mes);
            $metodo = MetodoPago::find($id);
            $this->idMetodo = $id;
            $this->idMensual = $mesual->id;
            $this->pagosEdit['monto'] = $metodo->monto;
            $this->pagosEdit['fecha'] = now()->toDateString();
            $this->tituloFormPago = $nombre.' '.$mesual->anio;
            $this->dispatch('modalPago', $id);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al obtener los datos: ' . $e->getMessage());
        }
    }
    public function guardarPago() {
        try {
            $this->validate([
                'pagosEdit.formaPago' => 'required|integer|exists:formas_pagos,id',
                'idMetodo' => 'required|numeric',
                'pagosEdit.fecha' => 'required|date',
                'pagosEdit.monto' => 'required|numeric|min:10',
                'pagosEdit.descripcion' => 'nullable|string',
            ]);
            
            PagoMensual::find($this->idMensual)->update(['pagado' => true]);

            Pagos::create([
                'responsable_id' => Auth::id(),
                'est_id' => $this->estudiante->id,
                'forma_id' => $this->pagosEdit['formaPago'],
                'metodo_id' => $this->idMetodo,
                'fecha' => $this->pagosEdit['fecha'],
                'monto' => $this->pagosEdit['monto'],
                'comentario' => $this->pagosEdit['descripcion'],
                'pagoMes_id' => $this->idMensual,
            ]);
            $this->resetForm();
            $this->llamadoPrincipal();
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
        $this->idMensual = '';
    }

}
