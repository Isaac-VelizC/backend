<?php

namespace App\Livewire\Docente;

use App\Models\CategoriaCriterio;
use App\Models\Criterio;
use App\Models\CursoHabilitado;
use App\Models\Trabajo;
use Livewire\Component;

class CriteriosTrabajos extends Component
{
    public $trabajos, $idCurso, $criterios, $categorias;
    public CursoHabilitado $materia;
    public $criteioEdit = ['nombre' => '', 'porcentaje' => 0, 'total' => 100];
    public $cat = ['criterio' => '', 'nombre' => '', 'porcentaje' => 0, 'total' => 100];

    public function mount($id) {
        $this->idCurso = $id;
        $this->materia = CursoHabilitado::find($id);
        $this->trabajos = Trabajo::where('curso_id', $id)->where('estado', '!=', 'Borrador')->get();
        $this->criterios = Criterio::all();
        $this->categorias = CategoriaCriterio::all();
    }
    public function render()
    {
        return view('livewire.docente.criterios-trabajos')->extends('layouts.app')->section('content');
    }
    public function criterioAdd() {
        $rules = [
            "criteioEdit.nombre" => 'required|string',
            "criteioEdit.porcentaje" => 'required|numeric|min:5',
            "criteioEdit.total" => 'required|numeric|max:100|min:100',
        ];
        $this->validate($rules);
        $this->guardarCriterio($this->criteioEdit, 'curso_id', $this->idCurso, Criterio::class);
    }
    public function categoriaAdd() {
        $rules = [
            "cat.criterio" => 'required|numeric',
            "cat.nombre" => 'required|string',
            "cat.porcentaje" => 'required|numeric|min:5',
            "cat.total" => 'required|numeric|max:100',
        ];
        $this->validate($rules);
        $this->guardarCriterio($this->cat, 'criterio_id', $this->cat['criterio'], CategoriaCriterio::class);
    }
    public function resetForm() {
        $this->criteioEdit = ['nombre' => '', 'porcentaje' => 0, 'total' => 100];
        $this->cat = ['criterio' => '', 'nombre' => '', 'porcentaje' => 0, 'total' => 100];
    }
    protected function guardarCriterio($data, $claveRelacion, $valorRelacion, $model) {
        try {
            $model::create([
                'nombre' => $data['nombre'],
                'porcentaje' => $data['porcentaje'], 
                'total' => $data['total'],
                $claveRelacion => $valorRelacion,
            ]);
            $this->resetForm();
            session()->flash('success', 'Se guardó con éxito');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }
}