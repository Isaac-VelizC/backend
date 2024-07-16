<?php

namespace App\Livewire\Admin;

use App\Models\DocTema;
use App\Models\Tema;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditTema extends Component
{
    
    use WithFileUploads;
    public $files = [], $filestema;
    public Tema $tema;

    public function mount($id) {
        $this->tema = Tema::find($id);
        $this->archivosCurso();
    }
    public function render()
    {
        return view('livewire.admin.edit-tema');
    }
    public function updatedFiles() {
        foreach ($this->files as $file) {
            $originalName = $file->getClientOriginalName();
            $filePath = $file->storeAs('public/files/tema', $originalName);
            $url = str_replace('public/', '', $filePath);
            DocTema::create([
                'nombre' => $originalName,
                'url' => 'storage/' . $url,
                'tema_id' => $this->tema->id
            ]);
        }
        $this->files = [];
        $this->archivosCurso();
    }
    public function eliminarFile($id) {
        DocTema::find($id)->delete();
        $this->archivosCurso();
    }
    public function archivosCurso() {
        $this->filestema = DocTema::where('tema_id', $this->tema->id)->get();
    }
}
