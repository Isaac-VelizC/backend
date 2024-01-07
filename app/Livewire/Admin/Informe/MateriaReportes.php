<?php

namespace App\Livewire\Admin\Informe;

use App\Models\Aula;
use App\Models\Curso;
use App\Models\CursoHabilitado;
use App\Models\Docente;
use App\Models\Horario;
use Livewire\Component;

class MateriaReportes extends Component
{
    public $materias;
    public $docentes;
    public $horarios;
    public $aulas;
    public $resultados;
    public $curso, $docente, $fecha, $horario, $aula, $estado;

    public function mount()
    {
        $this->docentes = Docente::all();
        $this->materias = Curso::all();
        $this->horarios = Horario::all();
        $this->aulas = Aula::all();
    }

    public function render()
    {
        return view('livewire.admin.informe.materia-reportes')->extends('layouts.app')->section('content');
    }

    public function resultMateriasReport() {
        try {
            $query = CursoHabilitado::query();

            $query->when($this->curso, function ($query, $curso) {
                $query->where('curso_id', $curso);
            });
            $query->when($this->docente, function ($query, $docente) {
                $query->where('docente_id', $docente);
            });
            $query->when($this->fecha, function ($query, $fecha) {
                $query->where('fecha_ini', $fecha);
            });
            $query->when($this->horario, function ($query, $horario) {
                $query->where('horario_id', $horario);
            });
            $query->when($this->aula, function ($query, $aula) {
                $query->where('aula_id', $aula);
            });
            if ($this->estado === false || $this->estado === '0') {
                $query->where('estado', false);
            } elseif (!is_null($this->estado)) {
                // Aquí ajustamos para manejar otros valores de $estado
                $query->where('estado', (bool)$this->estado);
            }
            $this->resultados = $query->get();

        } catch (\Exception $e) {
            session()->flash('error', 'Error al realizar la operación: ' . $e->getMessage());
        }
    }

    public function resetForm() {
        $this->resultados = '';
        $this->curso = ''; 
        $this->docente = ''; 
        $this->fecha = ''; 
        $this->horario = ''; 
        $this->aula = ''; 
        $this->estado = '';
    }

}
