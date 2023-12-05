<?php

namespace App\Livewire\Estudiante;

use App\Models\DocumentoDocente;
use App\Models\DocumentoEstudiante;
use App\Models\Trabajo;
use App\Models\TrabajoEstudiante;
use Livewire\Attributes\Validate;
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
        $this->archivosTarea();
    }
    public function updatedFiles() {

        if ($this->idTareaEstudiante == '') {
            $this->crearNuevo();
        }
        foreach ($this->files as $file) {
            $originalName = $file->getClientOriginalName();
            $filePath = $file->storeAs('public/trabajos', $originalName);
            $url = 'storage/' . $filePath;
            DocumentoEstudiante::create([
                'nombre' => $originalName,
                'url' => $url,
                'user_id' => auth()->user()->id,
                'entrega_id' => $this->idTareaEstudiante
            ]);
        }
        $this->files = [];
        $this->archivosTarea();
    }
    public function enviarTarea() {
        if ($this->idTareaEstudiante == '') {
            $this->crearNuevo();
        }
        TrabajoEstudiante::find($this->idTareaEstudiante)->update([
            //'descripcion' => $this->descripcion,
            'estado' => 'Entregado',
        ]);
        return redirect()->route('show.tarea', ['id' => $this->idTarea]);
    }
    public function crearNuevo() {
        $tarea = TrabajoEstudiante::create([
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
