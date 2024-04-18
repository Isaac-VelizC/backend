<?php

namespace App\Livewire\Docente;

use App\Models\CatCritTrabajo;
use App\Models\CategoriaCriterio;
use App\Models\Configuration;
use App\Models\Criterio;
use App\Models\CursoHabilitado;
use App\Models\Trabajo;
use Livewire\Component;

class CriteriosTrabajos extends Component
{
    public $criterios, $totalCursoOriginal, $totalPonderacion;
    public $criterioSeleccionado, $tipoCriterio, $isEditing = false, $idParaEditar;
    public $criteioEdit = ['nombre' => '', 'porcentaje' => ''];
    public $cat = ['criterio' => '', 'nombre' => '', 'porcentaje' => ''];

    public function mount() {
        $this->criterios = Criterio::all();
        $this->totalCursoOriginal = Configuration::find(1)->ponderacion;
    }

    public function criterioAdd() {
        $rules = [
            "criteioEdit.nombre" => 'required|string',
            "criteioEdit.porcentaje" => 'required|numeric|min:5|max:100',
            "totalPonderacion" => 'required|numeric|max:100|min:0',
        ];
        $this->validate($rules);
        $this->guardarCriterio($this->criteioEdit, Criterio::class, 'criterio');
    }

    public function actualizarTotalPonderacion() {
        if (empty($this->criteioEdit['porcentaje'])) {
            $this->totalPonderacion = $this->totalCursoOriginal;
        } elseif (is_numeric($this->criteioEdit['porcentaje'])) {
            $this->totalPonderacion = $this->totalCursoOriginal - $this->criteioEdit['porcentaje'];
            if ($this->totalPonderacion < 0 || $this->totalPonderacion > 100) {
                session()->flash('error', 'El % no puede ser menor a 0 ni mayor al total');
            }
        } else {
            session()->flash('error', 'El % no es un valor numérico.');
        }
    }

    protected function guardarCriterio($data, $model, $tipo) {
        try {
            if ($this->isEditing) {
                $instance = $model::find($this->idParaEditar);
        
                dd('Editar');
                /*if ($instance) {
                    $instance->update([
                        'nombre' => $data['nombre'],
                        'porcentaje' => $data['porcentaje'], 
                        'total' => $data['porcentaje'],
                        $claveRelacion => $valorRelacion,
                    ]);
            
                    if ($tipo == 'criterio') {
                        $this->ActualizarTotalDB($this->totalCurso);
                    } else {
                        $this->ActualizarTotalCat($this->totalPocentCategoria, $data['criterio']);
                    }
                    $this->isEditing = false;
                    $this->idParaEditar = '';
                }*/
            } else {
                $model::create([
                    'nombre' => $data['nombre'],
                    'porcentaje' => $data['porcentaje'], 
                    'total' => $data['porcentaje']
                ]);
                if ($tipo == 'criterio' ) {
                    $this->ActualizarTotalDB($this->totalPonderacion);
                } else {
                    $this->ActualizarTotalCat($this->totalPocentCategoria, $data['criterio']);
                }
            }
            $this->resetForm();
            session()->flash('success', 'Se guardó con éxito');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }
    

    public function render()
    {
        return view('livewire.docente.criterios-trabajos')->extends('layouts.app')->section('content');
    }
    
    /*
    private function llamadasModelos() {
        $this->criterios =  Criterio::where('curso_id', $this->idCurso)->get();
        //$criteriosConCategorias = Criterio::with('categorias')->get();
        $this->categorias = CategoriaCriterio::all();
        $this->totalCurso = $this->materia->nota_total;
        $this->totalCursoOriginal = $this->materia->nota_total;
        $this->totalPocentCategoria = 0;
        $this->totalCatOriginal = 0;
    }
    public $trabajos, $idCurso, $criterios, $categorias, $totalCurso, $totalCursoOriginal, $totalCatOriginal, $totalPocentCategoria;
    public $selectedTrabajos = [];
    public CursoHabilitado $materia;
    public $criterioSeleccionado, $tipoCriterio, $isEditing = false, $idParaEditar;
    protected $listeners = ['cerrarModal'];

    public function mount() {
        $this->idCurso = 1;
        $this->materia = CursoHabilitado::find(1);
        $this->trabajosSinCriterio();
        $this->llamadasModelos();
    }

    public function trabajosSinCriterio() {
        $this->trabajos = Trabajo::where('curso_id', $this->idCurso )
            ->where('estado', '!=', 'Borrador')
            ->whereNull('criterio_id')
            ->get();
    }
    
    public function render()
    {
        return view('livewire.docente.criterios-trabajos')->extends('layouts.app')->section('content');
    }
    
    public function categoriaAdd() {
        $rules = [
            "cat.criterio" => 'required|numeric|exists:criterios,id',
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
        $this->trabajosSinCriterio();
        $this->tipoCriterio = '';
        $this->selectedTrabajos = [];
        session()->flash('success', 'Se asignó con éxito');
    }
    public function quitarTrabajoCatCrit($id, $catId) {
        try {
            $trabajo = Trabajo::find($id);
            if (!$trabajo) {
                throw new \Exception('No se encontró el trabajo');
            }
            if ($catId !== 0) {
                $trabajo->catCritTrabajos()->where('cat_id', $catId)->delete();
            }
            $trabajo->update([
                'criterio_id' => null,
            ]);
            $this->trabajosSinCriterio();
            session()->flash('success', 'Operación realizada con éxito');
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }
    }
    public function editarCatCrit($id, $tipo) {
        try {
            $this->isEditing = true;
            $this->idParaEditar = $id;
    
            if ($tipo == 0) {
                $criterio = Criterio::find($id);
    
                if (!$criterio) {
                    throw new \Exception('No se encontró el criterio con ID ' . $id);
                }
    
                $this->criteioEdit['nombre'] = $criterio->nombre;
                $this->criteioEdit['porcentaje'] = $criterio->porcentaje;
                $this->totalCursoOriginal = $criterio->cursosHabilitado->nota_total + $criterio->total;
            } else {
                $cat = CategoriaCriterio::find($id);
    
                if (!$cat) {
                    throw new \Exception('No se encontró la categoría con ID ' . $id);
                }
    
                $this->cat['criterio'] = $cat->criterio_id;
                $this->cat['nombre'] = $cat->nombre;
                $this->cat['porcentaje'] = $cat->porcentaje;
                $this->totalCatOriginal = $cat->total;
                $this->totalPocentCategoria = $cat->criterio->total;
            }
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }
    
    public function borrarCatCrit($id, $tipo) {
        try {
            if ($tipo == 0) {
                $criterio = Criterio::find($id);
                if (!$criterio) {
                    throw new \Exception('No se encontró el criterio');
                }
                // Verificar si el criterio tiene categorías
                if ($criterio->categorias()->exists()) {
                    throw new \Exception('El criterio tiene categorías y no se puede borrar');
                }
                // Verificar si el criterio tiene relaciones con tareas
                if ($criterio->trabajos()->exists()) {
                    throw new \Exception('El criterio tiene relaciones con tareas y no se puede borrar');
                }
                $nota = $this->materia->nota_total + $criterio->total;
                $this->ActualizarTotalDB($nota);
                $criterio->delete();
            } else {
                $cat = CategoriaCriterio::find($id);
                if (!$cat) {
                    throw new \Exception('No se encontró la categoría con ID ' . $id);
                }
                if ($cat->catCritTrabajos()->exists()) {
                    throw new \Exception('La categoría tiene relaciones con tareas y no se puede borrar');
                }
                $criterio = Criterio::find($cat->criterio_id);
                if (!$criterio) {
                    throw new \Exception('No se encontró el criterio relacionado con la categoría');
                }
                $criterio->total = $criterio->total + $cat->total;
                $criterio->save();
                $cat->delete();
            }
            $this->llamadasModelos();
            session()->flash('success', 'Operación realizada con éxito');
        } catch (\Throwable $th) {
            // Manejo de excepciones
            session()->flash('error', $th->getMessage());
        }
    }*/
    
}
