<?php

namespace App\Livewire\Admin;

use App\Models\Evento;
use App\Models\TipoEvento;
use Livewire\Component;

class Calendario extends Component
{
    public $elementoSeleccionado;
    public $categorias, $eventId,  $modoEdicion = false;
    public $listeners = ['flash' => 'mostrarMensajeFlash'];
    public $eventos = [ 'nombre' => '', 'backgroundColor' => '#3788D8', 'textColor' => '#000000'];
    public function mount() {
        $this->categorias = TipoEvento::all();
    }
    public function mostrarMensajeFlash($message)
    {
        session()->flash('message', $message);
    }
    public function edit($id) {
        $category = TipoEvento::find($id);
        $this->eventId = $id;
        $this->modoEdicion = true;
        $this->eventos['nombre'] = $category->nombre;
        $this->eventos['backgroundColor'] = $category->backgroundColor;
        $this->eventos['textColor'] = $category->textColor;
    }
    public function update() {
        $this->validate([
            'eventos.nombre' => 'required|string|max:255',
            'eventos.backgroundColor' => 'required|string|max:255',
            'eventos.textColor' => 'string|max:255',
        ]);
        $category = TipoEvento::find($this->eventId);
        $category->update([
            'nombre' => $this->eventos['nombre'],
            'backgroundColor' => $this->eventos['backgroundColor'],
            'textColor' => $this->eventos['textColor'],
        ]);
        $this->resetForm();
    }
    public function store() {
        $this->validate([
            'eventos.nombre' => 'required|string|max:255',
            'eventos.backgroundColor' => 'required|string|max:255',
            'eventos.textColor' => 'string|max:255',
        ]);
        TipoEvento::create([
            'nombre' => $this->eventos['nombre'],
            'backgroundColor' => $this->eventos['backgroundColor'],
            'textColor' => $this->eventos['textColor'],
        ]);
        $this->resetForm();
    }
    public function eliminar() {
        $tipoEvento = TipoEvento::find($this->eventId);
        if ($tipoEvento) {
            $eventosAsociados = Evento::where('tipo_id', $tipoEvento->id)->count();
            if ($eventosAsociados > 0) {
                $this->mostrarMensajeFlash('No puedes eliminar este tipo de evento porque hay eventos asociados.');
            } else {
                $tipoEvento->delete();
            }
        }
        $this->resetForm();
    }
    private function resetForm() {
        $this->reset(['eventId', 'modoEdicion']);
        $this->eventos = [ 'nombre' => '', 'backgroundColor' => '#3788D8', 'textColor' => '#000000'];
        $this->mount();
    }
    public function render()
    {
        return view('livewire.admin.calendario');
    }
}
