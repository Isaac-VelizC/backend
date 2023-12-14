<?php

namespace App\Livewire\Docente\Components;

use App\Models\CursoHabilitado;
use App\Models\DocumentoDocente;
use App\Models\Tema;
use App\Models\TipoTrabajo;
use App\Models\Trabajo;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewTarea extends Component
{
    use WithFileUploads;
    public $idCurso, $idTarea, $idFiles, $tipoTrabajo, $tareas, $temasCurso;
    public CursoHabilitado $materia;
    public $tarea = ['titulo' => '', 'tipo' => '', 'tema' => '', 'fin' => '', 'con_nota' => false, 'nota' => '100', 'descripcion' => ''];
    public $files = [], $filesTarea;
    
    public function mount($id) {
        $this->idCurso = $id;
        $this->materia = CursoHabilitado::findOrFail($id);
        $this->temasCurso = Tema::where('curso_id', $id)->get();
        $this->tipoTrabajo = TipoTrabajo::all();
        $this->tarea['tipo'] = optional($this->tipoTrabajo->first())->id;
    }
    public function render()
    {
        return view('livewire.docente.components.new-tarea')->extends('layouts.app')
        ->section('content'); 
    }
    public function guardarTarea() {
        if ($this->tarea['nota'] === '' || (floatval($this->tarea['nota']) === 0 || !ctype_digit((string)$this->tarea['nota']))) {
            $this->tarea['nota'] = '100';
        }
        $this->validate([
            'tarea.tipo' => 'required|numeric',
            'tarea.tema' => 'nullable|numeric',
            'tarea.titulo' => 'required|string|max:255',
            'tarea.fin' => 'nullable|date',
            'tarea.con_nota' => 'required|boolean',
            'tarea.nota' => $this->tarea['con_nota'] ? 'required|numeric' : 'nullable|numeric',
        ]);
        if (!$this->idTarea) {
            $this->createTarea();
        }
        $tarea = Trabajo::find($this->idTarea);
        $tarea->fill([
            'tipo_id' => $this->tarea['tipo'],
            'titulo' => $this->tarea['titulo'],
            'inico' => now(),
            'fin' => $this->tarea['fin'] ?: null,
            'con_nota' => $this->tarea['con_nota'],
            'nota' => $this->tarea['nota'],
            'estado' => 'Publicado',
            'tema_id' => $this->tarea['tema'] ?: null,
            'descripcion' => $this->tarea['descripcion'] ?: null,
        ])->update();
        session()->flash('message', 'La tarea se publicó con éxito');
        // Redirigir a la página anterior
        $this->dispatch('redirectBack');
    }
    
    public function updatedFiles() {
        try {
            if (!$this->idTarea) {
                $this->createTarea();
            }
            foreach ($this->files as $file) {
                $originalName = $file->getClientOriginalName();
                $filePath = $file->storeAs('public/files', $originalName);
                $url = str_replace('public/', '', $filePath);

                DocumentoDocente::create([
                    'nombre' => $originalName,
                    'url' => 'storage/'.$url,
                    'fecha' => now(),
                    'materia_id' => $this->idCurso,
                    'user_id' => auth()->user()->id,
                    'tarea_id' => $this->idTarea
                ]);
            }
            $this->files = [];
            $this->archivosTarea();
        } catch (\Exception $e) {
            session()->flash('error', 'Error inesperado: ' . $e->getMessage());
        }
    }

    public function createTarea() {
        $tarea = Trabajo::create([
            'curso_id' => $this->idCurso, 'user_id' => auth()->user()->id, 'titulo' => ' '
        ]);
        $this->idTarea = $tarea->id;
    }
    public function eliminarFile($id) {
        DocumentoDocente::find($id)->delete();
        $this->archivosTarea();
    }
    public function archivosTarea() {
        $this->filesTarea = DocumentoDocente::where('tarea_id', $this->idTarea)->get();
    }
    public function salir() {
        if ($this->idTarea) {
            $tarea = Trabajo::find($this->idTarea)->delete();
            $docs = DocumentoDocente::where('tarea_id', $tarea->id)->get();
                if ($docs->isNotEmpty()) {
                    foreach ($docs as $doc) {
                        if (Storage::exists($doc->url)) {
                            Storage::delete($doc->url);
                        }
                        $doc->delete();
                    }
                }
                $tarea->delete();
        }
        $this->dispatch('redirectBack');
    }
}
