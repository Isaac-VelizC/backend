<?php

namespace App\Livewire\Docente;

use App\Models\CursoHabilitado;
use App\Models\HistorialInventario;
use App\Models\IngredientesCurso;
use App\Models\Inventario;
use Carbon\Carbon;
use Livewire\Component;

class TagIngredientes extends Component
{
    public $ingredientes, $seleccion, $ingredientesUso;
    public $quantity = 1;
    public CursoHabilitado $curso;
    public $cantidadSeleccion;

    public function mount($id) {
        $this->curso = CursoHabilitado::find($id);
        $this->llamadaIngrediente();
    }
    public function llamadaIngrediente() {
        $this->ingredientes = Inventario::where('estado', '!=', 'No disponible')->get();
        $this->ingredientesUso = IngredientesCurso::all();
    }    
    public function seleccionarIngrediente($id) {
        try {
            $this->seleccion = Inventario::find($id);
            $this->cantidadSeleccion = $this->seleccion->cantidad;
        } catch (\Throwable $th) {
            session()->flash('error', 'Ocurrio un error al seleccionar el ingrediente. '.$th->getMessage());
        }
    }
    public function borrarIngrediente($id) {
        try {
            $item = IngredientesCurso::find($id);
            if ($item) {
                $inventario = Inventario::find($item->inventario_id);
                $inventario->cantidad += $item->cantidad;
                $inventario->save();
                $item->delete();
                $this->llamadaIngrediente();
                session()->flash('success', 'Ingrediente eliminado correctamente.');
            } else {
                session()->flash('error', 'No se encontró el ingrediente.');
            }
        } catch (\Throwable $th) {
            session()->flash('error', 'Ocurrió un error al eliminar el ingrediente. ' . $th->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.docente.tag-ingredientes');
    }
    public function increment()
    {
        if ($this->quantity < $this->cantidadSeleccion) {
            $this->quantity++;
        }
    }
    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }
    public function guardarHistorial() {
        $this->validate([
            'quantity' => 'required|numeric|min:1|max:' . $this->cantidadSeleccion,
        ]);
        try {
            $item = Inventario::find($this->seleccion->id);
            $item->update([
                'cantidad' => $this->cantidadSeleccion - $this->quantity,
                'fecha_modificacion' => Carbon::now(),
            ]);
            $mesnaje = 'Una cantidad de '. $this->quantity .' que se esta usando en el curso '. $this->curso->curso->nombre;
            HistorialInventario::create([
                'cantidad' => $this->quantity,
                'user_id' => auth()->user()->id,
                'inventario_id' => $item->id,
                'descripcion' => $mesnaje,
                'fecha' => Carbon::now(),
            ]);
            IngredientesCurso::create([
                'cantidad' => $this->quantity,
                'curso_id' => $this->curso->id,
                'inventario_id' => $item->id,
                'descripcion' => $mesnaje,
                'fecha' => Carbon::now(),
            ]);
            $this->llamadaIngrediente();
            $this->resetForm();
            session()->flash('success', 'Registro correctamente.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Ocurrio un error. '.$th->getMessage());
        }
    }
    public function resetForm() {
        $this->seleccion = '';
        $this->quantity = 1;
        $this->cantidadSeleccion = '';
    }
}
