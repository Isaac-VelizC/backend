<?php

namespace App\Livewire\Estudiante;

use App\Models\DocumentoEstudiante;
use App\Models\Trabajo;
use App\Models\TrabajoEstudiante;
use Livewire\Component;
use Livewire\WithFileUploads;

class SubirTarea extends Component
{
    use WithFileUploads;
    //#[Validate(['files.*' => 'required|file|max:1024'])]
    public $idTarea, $authid, $edit;
    public Trabajo $trabajo;
    public $files = [], $filesTarea, $idTareaEstudiante = '', $descripcion = '';
    public function mount($id, $edit) {
        $this->edit = $edit;
        if (auth()->check() && auth()->user()->persona && auth()->user()->persona->estudiante) {
            $this->authid = auth()->user()->persona->estudiante->id;
        }
        $this->idTarea = $id;
        if (!$edit) { 
            $this->trabajo = Trabajo::find($id);
            $this->archivosTarea();
        } else {
            $enviado = TrabajoEstudiante::where(['trabajo_id' => $id, 'estudiante_id' => $this->authid])->first();
            $this->editarTarea($enviado->id);
        }
    }
    public function render()
    {
        return view('livewire.estudiante.subir-tarea')->extends('layouts.app')
        ->section('content');
    }
    public function editarTarea($id) {
        $tarea = TrabajoEstudiante::find($id);
        $this->idTareaEstudiante = $tarea->id;
        $this->descripcion = $tarea->descripcion;
        $this->archivosTarea();
    }
    public function updatedFiles() {
        try {
            $this->validateOnly('files', [
                'files.*' => 'file|max:2048',
            ]);

            if (empty($this->idTareaEstudiante)) {
                $this->crearNuevo();
            }
            foreach ($this->files as $file) {
                $originalName = $file->getClientOriginalName();
                $filePath = $file->storeAs('public/trabajos', $originalName);
                $url = str_replace('public/', '', $filePath);
                DocumentoEstudiante::create([
                    'nombre' => $originalName,
                    'url' => 'storage/'.$url,
                    'user_id' => auth()->user()->id,
                    'entrega_id' => $this->idTareaEstudiante
                ]);
            }

            $this->files = [];
            $this->archivosTarea();
        } catch (\Exception $e) {
            session()->flash('error', 'Error inesperado: ' . $e->getMessage());
        }
    }
    public function enviarTarea() {
        if ($this->idTareaEstudiante == '') {
            $this->crearNuevo();
        }
        TrabajoEstudiante::find($this->idTareaEstudiante)->update([
            'descripcion' => $this->descripcion,
            'estado' => 'Entregado',
        ]);
        return redirect()->route('show.tarea', ['id' => $this->idTarea]);
    }
    public function crearNuevo() {
        $tarea = TrabajoEstudiante::create([
            'curso_id' => $this->trabajo->curso->id,
            'trabajo_id' => $this->idTarea,
            'estudiante_id' => $this->authid,
        ]);
        $this->idTareaEstudiante = $tarea->id;
    }
    public function eliminarFile($id) {
        DocumentoEstudiante::find($id)->delete();
        $this->archivosTarea();
    }
    public function archivosTarea() {
        $this->filesTarea = DocumentoEstudiante::where('entrega_id', $this->idTareaEstudiante)->get();
    }
}
