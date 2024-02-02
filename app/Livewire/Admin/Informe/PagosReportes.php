<?php

namespace App\Livewire\Admin\Informe;

use App\Models\Estudiante;
use App\Models\PagoMensual;
use Livewire\Component;

class PagosReportes extends Component
{
    public $estudiantes, $startYear, $endYear, $months, $resultados = [];
    public $selectedYear, $selectedMonth, $selectEstudiante, $selectEstado;

    public function mount() {
        $this->estudiantes = Estudiante::all();
        $this->obtenerAniosMeses();
        $this->obtenerMeses();
    }

    public function obtenerAniosMeses() {
        $currentYear = date('Y');
        $this->startYear = $currentYear - 10;
        $this->endYear = $currentYear + 10;
    }

    public function obtenerMeses() {
        $this->months = [
            '1' => 'Enero',
            '2' => 'Febrero',
            '3' => 'Marzo',
            '4' => 'Abril',
            '5' => 'Mayo',
            '6' => 'Junio',
            '7' => 'Julio',
            '8' => 'Agosto',
            '9' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];
    }

    public function searchPagos() {
        try {
            $query = PagoMensual::query();
    
            $query->when($this->selectEstudiante, function ($q) {
                return $q->where('estudiante_id', $this->selectEstudiante);
            });
    
            $query->when($this->selectedYear, function ($q) {
                return $q->where('anio', $this->selectedYear);
            });
    
            $query->when($this->selectedMonth, function ($q) {
                return $q->where('mes', $this->selectedMonth);
            });
    
            $query->when($this->selectEstado, function ($q) {
                return $q->where('pagado', $this->selectEstado);
            });
    
            $this->resultados = $query->get();
        } catch (\Exception $e) {
            $this->resultados = [];
            session()->flash('error', 'Error al buscar pagos: ' . $e->getMessage());
        }
    }
    public function resetForm() {
        $this->selectedYear = '';
        $this->selectedMonth = '';
        $this->selectEstudiante = '';
        $this->selectEstado = '';
    }
    public function render()
    {
        return view('livewire.admin.informe.pagos-reportes')->extends('layouts.app')->section('content');
    }
}

