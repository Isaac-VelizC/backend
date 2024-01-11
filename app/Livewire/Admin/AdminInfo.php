<?php

namespace App\Livewire\Admin;

use App\Models\Aula;
use App\Models\CursoHabilitado;
use App\Models\Estudiante;
use App\Models\Horario;
use App\Models\MetodoPago;
use App\Models\Pagos;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminInfo extends Component
{
    public $horarios, $aulas, $metodoPagos;
    public $horariosEdit = ['turno' => '', 'inicio' => '', 'fin' => ''], $idHora = '';
    public $aulasEdit = ['nombre' => '', 'tipo' => 2, 'codigo' => '', 'capacidad' => ''], $idAula = '';
    public $metodoPagoEdit = '', $metodoMontoEdit = '' ,$idMetodo;
    public function mount() {
        $this->horarios = Horario::all();
        $this->aulas = Aula::all();
        $this->metodoPagos = MetodoPago::all();
    }
    public function render()
    {
        return view('livewire.admin.admin-info')->extends('layouts.app')->section('content');
    }
    public function seleccionarHorario($id) {
        $horario = Horario::find($id);
        $this->idHora = $horario->id;
        $this->horariosEdit['turno'] = $horario->turno;
        $this->horariosEdit['inicio'] = $horario->inicio;
        $this->horariosEdit['fin'] = $horario->fin;
    }
    public function formHorario() {
        try {
            if ($this->idHora != '') {
                $data = $this->validate([
                    'horariosEdit.turno' => 'required|string',
                    'horariosEdit.inicio' => 'required|date_format:H:i:s',
                    'horariosEdit.fin' => 'required|date_format:H:i:s|after:horariosEdit.inicio',
                ]);
                DB::table('horarios')->where('id', $this->idHora)->update($data['horariosEdit']);
            } else {
                $data = $this->validate([
                    'horariosEdit.turno' => 'required|string',
                    'horariosEdit.inicio' => 'required|date_format:H:i',
                    'horariosEdit.fin' => 'required|date_format:H:i|after:horariosEdit.inicio',
                ]);
                DB::table('horarios')->insert($data['horariosEdit']);
            }
            $this->resetForm();
            session()->flash('message', 'Operación completada con éxito.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al realizar la operación: ' . $e->getMessage());
        }
    }
    public function formAula() {
        $data = $this->validate([
            'aulasEdit.nombre' => 'required|string',
            'aulasEdit.tipo' => 'required|numeric',
            'aulasEdit.codigo' => 'required|unique:aulas,codigo,' . ($this->idAula ?: 'NULL') . ',id',
            'aulasEdit.capacidad' => 'required|numeric|min:1',
        ]);
        try {
            if ($this->idAula != '') {
                Aula::find($this->idAula)->update($data['aulasEdit']);
            } else {
                Aula::create($data['aulasEdit']);
            }
            $this->resetForm();
            session()->flash('message', 'Operación completada con éxito.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al realizar la operación: ' . $e->getMessage());
        }
    }
    public function formMetodo() {
        $data = $this->validate([
            'metodoPagoEdit' => 'required|string',
            'metodoMontoEdit' => 'required'
        ]);
        try {
            if ($this->idMetodo != '') {
                MetodoPago::find($this->idMetodo)->update([
                    'nombre' => $data['metodoPagoEdit'],
                    'monto' => $data['metodoMontoEdit'],
                ]);
            } else {
                MetodoPago::create([
                    'nombre' => $data['metodoPagoEdit'],
                    'monto' => $data['metodoMontoEdit'],
                ]);
            }
            $this->resetForm();
            session()->flash('message', 'Operación completada con éxito.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al realizar la operación: ' . $e->getMessage());
        }
    }
    public function borrarHorario($id) {
        $horario = Horario::find($id);
        $cursosRelacionadas = CursoHabilitado::where('horario_id', $id)->exists();
        $estudiantesRelacionados  = Estudiante::where('turno_id', $id)->exists();
        if ($cursosRelacionadas || $estudiantesRelacionados ) {
            session()->flash('error', 'No se puede eliminar el horario ya que está siendo utilizado.');
        } else {
            $horario->delete();
            session()->flash('message', 'Horario eliminado con éxito.');
            $this->mount();
        }
    }
    public function borrarAula($id) {
        $aula = Aula::find($id);
        $cursosRelacionadas = CursoHabilitado::where('aula_id', $id)->exists();
        if ($cursosRelacionadas ) {
            session()->flash('error', 'No se puede eliminar el aula ya que está siendo utilizado.');
        } else {
            $aula->delete();
            session()->flash('message', 'Aula eliminado con éxito.');
            $this->mount();
        }
    }
    public function resetForm()
    {
        $this->horariosEdit = ['turno' => '', 'inicio' => '', 'fin' => ''];
        $this->idHora = '';
        $this->aulasEdit = ['nombre' => '', 'tipo' => '', 'codigo' => '', 'capacidad' => ''];
        $this->idAula = '';
        $this->idMetodo = '';
        $this->metodoPagoEdit = '';
        $this->metodoMontoEdit = '';
        $this->mount();
    }
    public function seleccionarAula($id) {
            $aula = Aula::find($id);
            $this->idAula = $aula->id;
            $this->aulasEdit['nombre'] = $aula->nombre;
            $this->aulasEdit['codigo'] = $aula->codigo;
            $this->aulasEdit['capacidad'] = $aula->capacidad;

    }
    public function seleccionarMetodo($id) {
        $metodo =  MetodoPago::find($id);
        $this->idMetodo = $metodo->id;
        $this->metodoPagoEdit = $metodo->nombre;
        $this->metodoMontoEdit = $metodo->monto;
    }
    public function eliminarMetodo($id) {
        $aula = MetodoPago::find($id);
        $pagosRelacionadas = Pagos::where('metodo_id', $id)->exists();
        if ($pagosRelacionadas ) {
            session()->flash('error', 'No se puede eliminar el metodo de pago ya que está siendo utilizado.');
        } else {
            $aula->delete();
            session()->flash('message', 'Metodo de pago eliminado con éxito.');
            $this->mount();
        }
    }
}
