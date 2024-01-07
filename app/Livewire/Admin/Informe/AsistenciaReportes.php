<?php

namespace App\Livewire\Admin\Informe;

use App\Models\Asistencia;
use App\Models\CursoHabilitado;
use Livewire\Component;

class AsistenciaReportes extends Component
{
    public $materias;
    public $resultados, $materia, $fecha;

    public function mount() {
        $this->materias = CursoHabilitado::where('estado', 1)->get();
    }

    public function render()
    {
        return view('livewire.admin.informe.asistencia-reportes')->extends('layouts.app')->section('content');
    }
    public function searchAsistencias() {
        try {
            $query = Asistencia::query();

            $query->when($this->materia, function ($query, $materia) {
                $query->where('curso_id', $materia);
            });
            /*if ($this->estado === false || $this->estado === '0') {
                $query->where('estado', false);
            } elseif (!is_null($this->estado)) {
                $query->where('estado', (bool)$this->estado);
            }*/
            $this->resultados = $query->get();

        } catch (\Exception $e) {
            session()->flash('error', 'Error al realizar la operación: ' . $e->getMessage());
        }
    }
    public function resetForm() {
        $this->resultados = '';
        $this->materia = '';
        $this->fecha = '';
    }
}
