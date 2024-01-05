<?php

namespace App\Livewire\Docente;

use App\Models\CatCritTrabajo;
use App\Models\CategoriaCriterio;
use App\Models\Criterio;
use App\Models\CursoHabilitado;
use App\Models\Trabajo;
use Livewire\Component;

class CriteriosTrabajos extends Component
{
    public $trabajos, $idCurso, $criterios, $categorias, $totalCurso, $totalCursoOriginal, $totalCatOriginal, $totalPocentCategoria;
    public $selectedTrabajos = [];
    public CursoHabilitado $materia;
    public $criteioEdit = ['nombre' => '', 'porcentaje' => ''];
    public $cat = ['criterio' => '', 'nombre' => '', 'porcentaje' => ''];
    public $criterioSeleccionado, $tipoCriterio;
    protected $listeners = ['cerrarModal'];

    public function mount($id) {
        $this->idCurso = $id;
        $this->materia = CursoHabilitado::find($id);
        $this->trabajos = Trabajo::where('curso_id', $id)
            ->where('estado', '!=', 'Borrador')
            ->whereNull('criterio_id')
            ->get();
        $this->llamadasModelos();
    }

    private function llamadasModelos() {
        $this->criterios =  Criterio::where('curso_id', $this->idCurso)->get();
        //$criteriosConCategorias = Criterio::with('categorias')->get();
        $this->categorias = CategoriaCriterio::all();
        $this->totalCurso = $this->materia->nota_total;
        $this->totalCursoOriginal = $this->materia->nota_total;
        $this->totalPocentCategoria = 0;
        $this->totalCatOriginal = 0;
    }

    public function actualizarTotalCurso() {
        if (empty($this->criteioEdit['porcentaje'])) {
            $this->totalCurso = $this->totalCursoOriginal;
        } elseif (is_numeric($this->criteioEdit['porcentaje'])) {
            $this->totalCurso = $this->totalCursoOriginal - $this->criteioEdit['porcentaje'];
            if ($this->totalCurso < 0 || $this->totalCurso > 100) {
                session()->flash('error', 'El % no puede ser menor a 0 ni mayor al total');
            }
        } else {
            session()->flash('error', 'El % no es un valor numérico.');
        }
    }
    public function render()
    {
        return view('livewire.docente.criterios-trabajos')->extends('layouts.app')->section('content');
    }
    public function criterioAdd() {
        $rules = [
            "criteioEdit.nombre" => 'required|string',
            "criteioEdit.porcentaje" => 'required|numeric|min:5|max:100',
            "totalCurso" => 'required|numeric|max:100|min:0',
        ];
        $this->validate($rules);
        $this->guardarCriterio($this->criteioEdit, 'curso_id', $this->idCurso, Criterio::class, 'criterio');
    }
    public function categoriaAdd() {
        $rules = [
            "cat.criterio" => 'required|numeric',
            "cat.nombre" => 'required|string',
            "cat.porcentaje" => 'required|numeric|min:2|max:'.$this->totalCatOriginal,
            "totalPocentCategoria" => 'required|numeric|max:100',
        ];
        $this->validate($rules);
        $this->guardarCriterio($this->cat, 'criterio_id', $this->cat['criterio'], CategoriaCriterio::class, 'cat');
    }
    public function obtenerPorcentajeCriterioSeleccionado() {
        $criterioSeleccionado = Criterio::find($this->cat['criterio']);
        if ($criterioSeleccionado) {
            $this->totalPocentCategoria = $criterioSeleccionado->total;
            $this->totalCatOriginal = $criterioSeleccionado->total;
        }
    }
    public function calcularTotalCategoria() {
        if (empty($this->cat['porcentaje'])) {
            $this->totalPocentCategoria = $this->totalCatOriginal;
        } elseif (is_numeric($this->cat['porcentaje'])) {
            $porcentaje = $this->cat['porcentaje'];
            $this->totalPocentCategoria = $this->totalCatOriginal - $porcentaje;
            if ($this->totalPocentCategoria < 0 || $this->totalPocentCategoria > $this->totalCatOriginal) {
                session()->flash('error', 'El % no puede ser menor a 0 ni mayor al total');
            }
        } else {
            session()->flash('error', 'El % no es un valor numérico.');
        }
    }
    public function resetForm() {
        $this->criteioEdit = ['nombre' => '', 'porcentaje' => ''];
        $this->cat = ['criterio' => '', 'nombre' => '', 'porcentaje' => ''];
        $this->llamadasModelos();
    }
    protected function guardarCriterio($data, $claveRelacion, $valorRelacion, $model, $tipo) {
        try {
            $model::create([
                'nombre' => $data['nombre'],
                'porcentaje' => $data['porcentaje'], 
                'total' => $data['porcentaje'],
                $claveRelacion => $valorRelacion,
            ]);
            if ($tipo == 'criterio' ) {
                $this->ActualizarTotalDB($this->totalCurso);
            } else {
                $this->ActualizarTotalCat($this->totalPocentCategoria, $data['criterio']);
            }
            $this->resetForm();
            session()->flash('success', 'Se guardó con éxito');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }
    protected function ActualizarTotalDB($nota) {
        $this->materia->update([
            'nota_total' => $nota,
        ]);
    }
    protected function ActualizarTotalCat($nota, $idCriterio) {
        Criterio::find($idCriterio)->update([
            'total' => $nota,
        ]);
    }
    public function mostrarModal($id, $tipo) {
        $this->tipoCriterio = $tipo;
        if ($tipo == 0) {
            $this->criterioSeleccionado = Criterio::find($id);
        } else if ($tipo == 1) {
            $this->criterioSeleccionado = CategoriaCriterio::find($id);
        }
        $this->dispatch('mostrarModal', $this->criterioSeleccionado);
    }

    public function asignarCriterios($idCriterio) {
        $trabajosIds = array_keys(array_filter($this->selectedTrabajos));
    
        if ($this->tipoCriterio == 0) {
            Trabajo::whereIn('id', $trabajosIds)
                ->update(['criterio_id' => $idCriterio]);
        } else if ($this->tipoCriterio == 1) {
            $cat = CategoriaCriterio::find($idCriterio);
    
            Trabajo::whereIn('id', $trabajosIds)
                ->update(['criterio_id' => $cat->criterio->id]);
    
            foreach ($trabajosIds as $idTrabajo) {
                CatCritTrabajo::create([
                    'cat_id' => $idCriterio,
                    'tarea_id' => $idTrabajo
                ]);
            }
        }
        $this->tipoCriterio = '';
        $this->selectedTrabajos = [];
        session()->flash('success', 'Se asignó con éxito');
    }
}
