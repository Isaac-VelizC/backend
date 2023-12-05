<?php

namespace App\Livewire\Docente\Components;

use App\Models\DocumentoCurso;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ConfigDocs extends Component
{
    use WithFileUploads;
    #[Validate(['files.*' => 'file|max:1024'])]
    public $idCurso, $files = [], $filesCurso;
    public function mount($id) {
        $this->idCurso = $id;
        $this->archivosCurso();
    }
    public function render()
    {
        return view('livewire.docente.components.config-docs');
    }
    public function updatedFiles() {
        foreach ($this->files as $file) {
            $originalName = $file->getClientOriginalName();
            $filePath = $file->storeAs('public/files/curso' . $this->idCurso, $originalName);
            $url = 'storage/' . $filePath;
            DocumentoCurso::create([
                'nombre' => $originalName,
                'url' => $url,
                'curso_id' => $this->idCurso,
                'user_id' => auth()->user()->id
            ]);
        }
        $this->files = [];
        $this->archivosCurso();
    }
    public function eliminarFile($id) {
        DocumentoCurso::find($id)->delete();
        $this->archivosCurso();
    }
    public function archivosCurso() {
        $this->filesCurso = DocumentoCurso::where('curso_id', $this->idCurso)->get();
    }
    
}
