<?php

namespace App\Livewire;

use App\Models\Estudiante;
use App\Models\Persona;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfilePage extends Component
{
    
    use WithFileUploads;
    public $info, $user, $famil, $perfil, $Rolestudiante = false, $Roldocente = false;   
    public function mount()
    {
        $this->user = User::find(auth()->user()->id);
        $this->rolUser();
        $this->info = Persona::where('user_id', auth()->user()->id)->first();
        $estudiante = Estudiante::where('persona_id', $this->info->id)->first();
        if ($estudiante) {
            $pers = $estudiante->contacto;
            $this->famil = Persona::find($pers->persona_id);
        }

    }
    public function render()
    {
        return view('livewire.profile-page')->extends('layouts.app')->section('content');
    }
    public function rolUser() {
        if (auth()->user()->hasRole('Estudiante')) {
            $this->Rolestudiante = true;
        } elseif (auth()->user()->hasRole('Docente')) {
            $this->Roldocente = true;
        }
    }
    public function updatedPerfil() {
        try {
            $this->validateOnly('perfil', [
                'perfil' => 'image|mimes:jpeg,png,jpg|max:5120',
            ]);
            if ($this->perfil) {
                $path = $this->perfil->store('public/photos');
                $path = str_replace('public/', '', $path);
                if ($path) {
                    $info = Persona::where('user_id', auth()->user()->id)->first();
                    $info->photo = $path;
                    $info->update();
                    session()->flash('message', 'La foto se ha cargado exitosamente.');
                } else {
                    session()->flash('error', 'Error al cargar la foto.');
                }
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error inesperado: ' . $e->getMessage());
        }
    }

}
