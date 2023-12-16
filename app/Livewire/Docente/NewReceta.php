<?php

namespace App\Livewire\Docente;

use App\Models\Ingrediente;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewReceta extends Component
{
    use WithFileUploads;
    public $recetaEdit = ['titulo' => '', 'descripcion' => '', 'imagen' => ''], $ingrediente = '';
    public $pasoEdit = ['descripcion' => ''];
    public $tiempo = 0, $porcion = 2;
    public $ingreditenteDatos = ['cantidad' => 1, 'unidades' => ''];
    public $pasos = [], $ingredientesSeleccionados = [], $ocasion = [], $ingredienteEdit = [];
    public $contadorPasos = 1, $botonActivado = false;
    public function activarBoton() {
        $this->botonActivado = true;
    }
    public function addPaso() {
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
    public function eliminarPaso($indice) {
        unset($this->pasos[$indice]);
        $this->pasos = array_values($this->pasos);
        foreach ($this->pasos as $indice => $paso) {
            $this->pasos[$indice]['numero'] = $indice + 1;
        }
    }
    public function incrementar() {
        $this->tiempo += 5;
    }
    public function decrementar() {
        $this->tiempo = max(0, $this->tiempo - 5);
    }
    public function incrementPorcion() {
        $this->porcion += 1;
    }
    public function decrementPorcion() {
        $this->porcion = max(0, $this->porcion - 1);
    }
    public function seleccionarIngrediente($id) {
        $ingrediente = Ingrediente::find($id);
        /*if ($ingrediente) {
            $this->ingredientesSeleccionados[] = $ingrediente;
        }*/
        if ($ingrediente) {
            $this->ingredientesSeleccionados[] = [
                'id' => $ingrediente->id,
                'nombre' => $ingrediente->nombre,
                'cantidad' => 1,
                'unidades' => '',
            ];
        }
        $this->ingrediente = '';
    }
    public function abrirModalEdicion($ingrediente) {
        $this->ingredienteEdit = $ingrediente;
        $this->dispatch('abrirModalEdicion', [$ingrediente['id']]);
    }
    public function guardarCantidadUnidades($id) {
        $indice = array_search($id, array_column($this->ingredientesSeleccionados, 'id'));
        if ($indice !== false) {
            $this->ingredientesSeleccionados[$indice]['cantidad'] = $this->ingreditenteDatos['cantidad'];
            $this->ingredientesSeleccionados[$indice]['unidades'] = $this->ingreditenteDatos['unidades'];
        }
        $this->reset(['ingreditenteDatos']);
    }
    public function modalIngredietneCantidaUnid($id) {
        $indice = array_search($id, array_column($this->ingredientesSeleccionados, 'id'));
        if ($indice !== false) {
            $this->ingreditenteDatos['cantidad'] = $this->ingredientesSeleccionados[$indice]['cantidad'];
            $this->ingreditenteDatos['unidades'] = $this->ingredientesSeleccionados[$indice]['unidades'];
        }
        $this->dispatch('abrirModalIngrediente', $id);
    }
    public function render()
    {
        return view('livewire.docente.new-receta')->extends('layouts.app')->section('content');
    }
    public function numeroALetras($numero) {
        $unidades = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
        $decenas = ['', '', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
        if ($numero < 10) {
            return $unidades[$numero];
        } elseif ($numero < 20) {
            $especiales = ['diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];
            return $especiales[$numero - 10];
        } else {
            $unidad = $numero % 10;
            $decena = floor($numero / 10);

            return $decenas[$decena] . ($unidad > 0 ? ' y ' . $unidades[$unidad] : '');
        }
    }
    public function eliminarIngrediente($id) {
        $this->ingredientesSeleccionados = array_filter($this->ingredientesSeleccionados, function ($ingrediente) use ($id) {
            return $ingrediente['id'] != $id;
        });
    }
    public function guardarReceta()
    {
        //$this->recetaEdit
        //$this->porcion; $this->tiempo
        //$this->pasos; $this->ocasion
        dd($this->ingredientesSeleccionados);

        $this->resetForm();
    }
    public function resetForm() {
        $this->botonActivado = false;
        $this->recetaEdit = ['titulo' => ''];
    }
}
