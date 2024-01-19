<?php

namespace App\Livewire\Admin;

use App\Models\Tema;
use Livewire\Component;

class EditTema extends Component
{
    public Tema $tema;
    public $editar = ['nombre' => '', 'descripcion' => ''];

    public function mount($id) {
        $this->tema = Tema::find($id);
        $this->editarTema();
    }
    public function editarTema() {
        $this->editar['nombre'] = $this->tema->tema;
        $this->editar['descripcion'] = $this->tema->descripcion;
    }
    public function actualizarTema() {
        try {
            dd($this->editar['descripcion']);
            $name = $this->editar['nombre'];
            if ($name != '') {
                $this->tema->update([
                    'tema' => $name,
                    'descripcion' => $this->editar['descripcion'],
                ]);
                return redirect()->route('cursos.curso', $this->tema->curso_id);
            } else {
                session()->flash('error', 'Debe de ingresar un Titulo');
            }
        } catch (\Throwable $th) {
            session()->flash('error', 'Hubo un error al procesar la solicitud: ' . $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.admin.edit-tema')->extends('layouts.app')->section('content');
    }
}
