<?php

namespace App\Livewire\Docente;

use App\Models\ComentarioCurso;
use App\Models\CursoHabilitado;
use App\Models\DocTema;
use App\Models\DocumentoDocente;
use App\Models\Tema;
use App\Models\Trabajo;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Trabajos extends Component
{
    public $tema, $idCurso, $temasCurso, $tareas, $comentario = '';
    public $AD3 = false;
    public CursoHabilitado $materia;
    public $comentariosCurso, $usuariosID;
    public function mount($id) {
        $this->usuariosID = auth()->user()->persona->estudiante->id ?? 0;
        $this->idCurso = $id;
        $this->materia = CursoHabilitado::findOrFail($id);
        $this->temasCurso = Tema::where('curso_id', $id)->get();
        $allTareas = Trabajo::where('curso_id', $id)->where('estado', '!=', 'Borrador')->get();
        $this->tareas = collect($allTareas)->groupBy('tema_id');
        $this->loadComentarios();
    }
    public function abrirFormTema() {
        $this->resetearForm();
        $this->AD3 = true;
    }
    public function formTema() {
        $this->validate(['tema' => 'required|string|min:5|max:255']);
        Tema::create(['tema' => $this->tema, 'curso_id' => $this->idCurso,]);
        session()->flash('message', 'El Tema se creo con éxito');
        $this->tema = '';
        $this->AD3 = false;
        $this->mount($this->idCurso);
    }
    public function resetearForm() {
        $this->AD3 = false;
        $this->mount($this->idCurso);
    }
    public function borrarTema($id) {
        try {
            $item = Tema::find($id);
            if (!$item) {
                throw new \Exception('Tema no encontrado');
            }
            $files = DocTema::where('tema_id', $item->id)->get();
            if (count($files) > 0) {
                foreach ($files as $file) {
                    $file->delete();
                }
            }
            $item->delete();
            $this->mount($this->idCurso);
            session()->flash('message', 'Tema y archivos asociados eliminados correctamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al intentar borrar el tema: ' . $e->getMessage());
        }
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
