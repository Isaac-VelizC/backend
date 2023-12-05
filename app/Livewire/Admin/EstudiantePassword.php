<?php

namespace App\Livewire\Admin;

use App\Models\Estudiante;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class EstudiantePassword extends Component
{
    public $idUser, $pass, $passConfirm;
    public function mount($id) {
        $item = Persona::find($id);
        $this->idUser = $item->user->id;
        if (!$item) {
            abort(404, 'Estudiante no encontrado');
        }
    }
    public function render()
    {
        return view('livewire.admin.estudiante-password');
    }
    public function cambiarPassword() {
        $rules = [
            'pass' => 'required|min:8',
            'passConfirm' => 'required|same:pass',
        ];
        $this->validate($rules);
        $doc = User::find($this->idUser);
        $doc->password = Hash::make($this->passConfirm);
        $doc->save();
        $this->reset(['pass', 'passConfirm']);
        session()->flash('confirm', 'Contraseña actualizada.');
    }
}
