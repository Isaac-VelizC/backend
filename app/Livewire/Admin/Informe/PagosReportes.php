<?php

namespace App\Livewire\Admin\Informe;

use App\Models\Estudiante;
use App\Models\FormaPago;
use App\Models\Pagos;
use Livewire\Component;

class PagosReportes extends Component
{
    public $estudiantes, $formasPago, $startYear, $endYear, $months, $resultados = [];
    public $selectedYear, $selectedMonth, $selectForma, $selectEstudiante, $selectEstado;

    public function mount() {
        $this->estudiantes = Estudiante::all();
        $this->formasPago = FormaPago::all();
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
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];
    }

    public function searchPagos() {
        try {
            $query = Pagos::query();
    
            if ($this->selectedYear) {
                $query->whereYear('fecha', $this->selectedYear);
            }
    
            if ($this->selectedMonth) {
                $query->whereMonth('fecha', $this->selectedMonth);
            }
    
            if ($this->selectForma) {
                $query->where('forma_id', $this->selectForma);
            }
    
            if ($this->selectEstudiante) {
                $query->where('est_id', $this->selectEstudiante);
            }
    
            $this->resultados = $query->get();
        } catch (\Exception $e) {
            $this->resultados = [];
            session()->flash('error', 'Error al buscar pagos: ' . $e->getMessage());
        }
    }    

    public function render()
    {
        return view('livewire.admin.informe.pagos-reportes')->extends('layouts.app')->section('content');
    }
}

