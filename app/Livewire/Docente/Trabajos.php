<?php

namespace App\Livewire\Docente;

use App\Models\ComentarioCurso;
use App\Models\CursoHabilitado;
use App\Models\DocumentoDocente;
use App\Models\Tema;
use App\Models\Trabajo;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Trabajos extends Component
{
    public $tema, $idCurso, $idTarea, $idFiles, $temasCurso, $tipoTrabajo, $tareas, $comentario = '';
    public $AD3 = false, $temaEditando = null;
    public CursoHabilitado $materia;
    public $temaEditado = '', $comentariosCurso;
    public $files = [], $filesTarea, $temasEditados = [];
    public function mount($id) {
        $this->idCurso = $id;
        $this->materia = CursoHabilitado::findOrFail($id);
        $this->temasCurso = Tema::where('curso_id', $id)->get();
        $this->temasEditados = $this->temasCurso->pluck('tema', 'id')->toArray();
        $allTareas = Trabajo::where('curso_id', $id)->where('estado', '!=', 'Borrador')->get();
        $this->tareas = collect($allTareas)->groupBy('tema_id');
        $this->loadComentarios();
    }
    public function abrirFormTema() {
        $this->resetearForm();
        $this->AD3 = true;
    }
    public function formTema() {
        $this->validate(['tema' => 'required|string|max:255']);
        Tema::create(['tema' => $this->tema, 'curso_id' => $this->idCurso,]);
        session()->flash('message', 'El Tema se creo con éxito');
        $this->tema = '';
        $this->AD3 = false;
        $this->mount($this->idCurso);
    }
    public function resetearForm() {
        $this->AD3 = false;
        $this->mount($this->idCurso);
        $this->idTarea = null;
        $this->idFiles = null;
        $this->files = [];
        $this->filesTarea = collect([]);
    }
    public function editarTema($itemId) {
        $this->temaEditando = $itemId;
        $this->temaEditado = Tema::find($itemId)->tema;
    }
    public function actualizarTema($itemId) {
        $tema = Tema::find($itemId);
        if ($tema) {
            $tema->tema = $this->temasEditados[$itemId];
            $tema->update();
        }
        $this->temaEditando = null;
    }
    public function borrarTema($id) {
        Tema::find($id)->delete();
        $this->mount($this->idCurso);
    }
    public function render()
    {
        return view('livewire.docente.trabajos');
    }
    public function eliminarTarea($id) {
        $tarea = Trabajo::find($id);
        try {
            if ($tarea) {
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
                $this->mount($this->idCurso);
                session()->flash('message', 'Se eliminó la tarea con éxito');
            } else {
                session()->flash('error', 'No se encontró la tarea que intentas eliminar.');
            }
        } catch (\Exception $e) {
            session()->flash('error',  $e->getMessage());
        }
    }
    public function addComentario() {
        try {
            ComentarioCurso::create([
                'body' => $this->comentario,
                'action' => true,
                'autor_id' => auth()->user()->id,
                'curso_id' => $this->idCurso
            ]);

            $this->comentario = '';
            $this->loadComentarios();

            session()->flash('message', 'Se subió el comentario con éxito');

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }
    public function deleteComentario($id) {
        try {
            ComentarioCurso::find($id)->delete();
            $this->loadComentarios();
            session()->flash('message', 'El comentario se elimino con éxito');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }
    public function loadComentarios()
    {
        $this->comentariosCurso = ComentarioCurso::where('curso_id', $this->idCurso)->get();
    }

}
