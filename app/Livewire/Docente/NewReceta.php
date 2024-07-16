<?php

namespace App\Livewire\Docente;

use App\Models\Ingrediente;
use App\Models\IngredienteReceta;
use App\Models\PasosReceta;
use App\Models\Receta;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewReceta extends Component
{
    use WithFileUploads;

    public $recetaEdit = ['titulo' => '', 'descripcion' => ''];
    public $ingrediente = '';
    public $imagen;
    public $pasoEdit = ['descripcion' => ''];
    public $tiempo = 5;
    public $porcion = 2;
    public $ingreditenteDatos = ['cantidad' => 1, 'unidades' => ''];
    public $pasos = [];
    public $ingredientesSeleccionados = [];
    public $ocasion = [];
    public $ingredienteEdit = [];
    public $contadorPasos = 1;

    public function addPaso()
    {
        if (empty($this->pasos)) {
            $this->contadorPasos = 1;
        }
        $this->pasos[] = [
            'descripcion' => $this->pasoEdit['descripcion'],
            'numero' => $this->contadorPasos,
        ];

        $this->contadorPasos++;
        $this->pasoEdit['descripcion'] = '';
    }

    public function eliminarPaso($indice)
    {
        unset($this->pasos[$indice]);
        $this->pasos = array_values($this->pasos);
        foreach ($this->pasos as $indice => $paso) {
            $this->pasos[$indice]['numero'] = $indice + 1;
        }
    }

    public function incrementar()
    {
        $this->tiempo += 5;
    }

    public function decrementar()
    {
        $this->tiempo = max(5, $this->tiempo - 5);
    }

    public function incrementPorcion()
    {
        $this->porcion += 1;
    }

    public function decrementPorcion()
    {
        $this->porcion = max(1, $this->porcion - 1);
    }

    public function seleccionarIngrediente($id)
    {
        $ingrediente = Ingrediente::find($id);
        if ($ingrediente) {
            $this->ingredientesSeleccionados[] = [
                'id' => $ingrediente->id,
                'nombre' => $ingrediente->nombre,
                'cantidad' => 1,
                'unidades' => null,
            ];
        }
        $this->ingrediente = '';
    }

    public function guardarCantidadUnidades($id)
    {
        $indice = array_search($id, array_column($this->ingredientesSeleccionados, 'id'));
        if ($indice !== false && isset($this->ingreditenteDatos[$id])) {
            $this->ingredientesSeleccionados[$indice]['cantidad'] = $this->ingreditenteDatos[$id]['cantidad'] ?? 1;
            $this->ingredientesSeleccionados[$indice]['unidades'] = $this->ingreditenteDatos[$id]['unidades'] ?? null;
        }
    }

    public function abrirModalEdicion($ingrediente)
    {
        $this->ingredienteEdit = $ingrediente;
        $this->dispatch('abrirModalEdicion', [$ingrediente['id']]);
    }

    public function eliminarIngrediente($id)
    {
        $this->ingredientesSeleccionados = array_filter($this->ingredientesSeleccionados, function ($ingrediente) use ($id) {
            return $ingrediente['id'] != $id;
        });
    }

    public function guardarReceta()
    {
        $this->validate([
            'recetaEdit.titulo' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'recetaEdit.descripcion' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'porcion' => 'required|numeric|min:1',
            'tiempo' => 'required|numeric|min:5',
            'ocasion' => 'required|array|min:1',
            'ingredientesSeleccionados' => 'required|array|min:1',
            'ingredientesSeleccionados.*.id' => 'required|exists:ingredientes,id',
            'ingredientesSeleccionados.*.cantidad' => 'required|numeric|min:1',
            'ingredientesSeleccionados.*.unidades' => 'required|string',
            'pasos' => 'required|array|min:1',
            'pasos.*.descripcion' => 'required|string|max:255',
        ]);

        try {
            $receta = new Receta();
            $receta->fill([
                'titulo' => $this->recetaEdit['titulo'],
                'descripcion' => $this->recetaEdit['descripcion'],
                'porcion' => $this->porcion,
                'tiempo' => $this->tiempo,
                'ocasion' => json_encode($this->ocasion),
                'docente_id' => auth()->user()->persona->docente->id
            ]);

            if ($this->imagen) {
                $path = $this->imagen->store('public/recetas');
                $path = str_replace('public/', '', $path);
                $receta->imagen = 'storage/' . $path;
            }
            $receta->save();

            $this->guardarPasosReceta($receta->id);
            $this->guardarIngredientesReceta($receta->id);

            session()->flash('success', 'Receta registrada con éxito');
            $this->resetForm();
            return redirect()->route('admin.show.receta', $receta->id);
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }
    }

    private function guardarPasosReceta($recetaId)
    {
        foreach ($this->pasos as $paso) {
            PasosReceta::create([
                'paso' => $paso['descripcion'],
                'numero' => $paso['numero'],
                'receta_id' => $recetaId,
            ]);
        }
    }

    private function guardarIngredientesReceta($recetaId)
    {
        foreach ($this->ingredientesSeleccionados as $ingrediente) {
            IngredienteReceta::create([
                'ingrediente_id' => $ingrediente['id'],
                'cantidad' => $ingrediente['cantidad'],
                'unida_media' => $ingrediente['unidades'],
                'receta_id' => $recetaId,
            ]);
        }
    }

    public function resetForm()
    {
        $this->recetaEdit = [
            'titulo' => '',
            'descripcion' => ''
        ];
        $this->imagen = null;
        $this->ingrediente = '';
        $this->pasoEdit = [
            'descripcion' => '',
        ];
        $this->tiempo = 5;
        $this->porcion = 2;
        $this->ingreditenteDatos = [
            'cantidad' => 1,
            'unidades' => '',
        ];
        $this->pasos = [];
        $this->ingredientesSeleccionados = [];
        $this->ocasion = [];
        $this->ingredienteEdit = [];
        $this->contadorPasos = 1;
    }

    public function render()
    {
        return view('livewire.docente.new-receta')
            ->extends('layouts.app')
            ->section('content');
    }
}
