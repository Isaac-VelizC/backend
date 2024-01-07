<?php

namespace App\Livewire\Admin\Informe;

use App\Models\Estudiante;
use App\Models\Horario;
use App\Models\Semestre;
use Livewire\Component;

class EstudianteReportes extends Component
{
    public $horarios;
    public $semestres;
    public $resultados, $horario, $semestre, $fecha, $estado;

    public function mount() {
        $this->horarios = Horario::all();
        $this->semestres = Semestre::all();
    }

    public function render()
    {
        return view('livewire.admin.informe.estudiante-reportes')->extends('layouts.app')->section('content');
    }
    public function searchEstudiantes() {
        try {
            $query = Estudiante::query();

            $query->when($this->horario, function ($query, $horario) {
                $query->where('turno_id', $horario);
            });
            /*$query->when($this->semestre, function ($query, $semestre) {
                $query->where('semestre_id', $semestre);
            });*/
            if ($this->estado === false || $this->estado === '0') {
                $query->where('estado', false);
            } elseif (!is_null($this->estado)) {
                $query->where('estado', (bool)$this->estado);
            }
            $this->resultados = $query->get();

        } catch (\Exception $e) {
            session()->flash('error', 'Error al realizar la operación: ' . $e->getMessage());
        }
    }
    public function resetForm() {
        $this->resultados = '';
        $this->horario = '';
        $this->semestre = '';
        $this->fecha = '';
        $this->estado = '';
    }
}
