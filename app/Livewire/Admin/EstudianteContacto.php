<?php

namespace App\Livewire\Admin;

use App\Models\Contacto;
use App\Models\Estudiante;
use App\Models\NumTelefono;
use App\Models\Persona;
use Livewire\Component;

class EstudianteContacto extends Component
{
    public Persona $persona;
    public $num;
    public $contactId = '';

    public $contactoEdit = [
        'nombre' => '',
        'paterno' => '',
        'materno' => '',
        'cedula' => '',
        'genero' => '',
        'celular' => '',
        'email' => '',
    ];

    public function mount(Estudiante $estudiante)
    {
        $contacto = Contacto::find($estudiante->contact_id);
        $this->num = NumTelefono::where('id_persona', $contacto->persona_id)->first();
        $this->contactId = $contacto->id;
        $this->persona = Persona::find($contacto->persona_id);
        $this->edit();
    }

    public function edit() {
        $this->contactoEdit['nombre'] = $this->persona->nombre;
        $this->contactoEdit['paterno'] = $this->persona->ap_paterno;
        $this->contactoEdit['materno'] = $this->persona->ap_materno;
        $this->contactoEdit['cedula'] = $this->persona->ci;
        $this->contactoEdit['genero'] = $this->persona->genero;
        $this->contactoEdit['celular'] = $this->num->numero;  
        $this->contactoEdit['email'] = $this->persona->email;  
    }

    public function update() {
        $rules = [
            'contactoEdit.nombre' => 'required|string',
            'contactoEdit.paterno' => 'string',
            'contactoEdit.materno' => 'string',
            'contactoEdit.cedula' => 'required|string|unique:personas,ci,' . $this->persona->id,
            'contactoEdit.genero' => 'required|in:Mujer,Hombre',
            'contactoEdit.email' => 'nullable|email|unique:personas,email,' . $this->persona->id,
        ];
        $this->validate($rules);
        $this->persona->update([
            'nombre' => $this->contactoEdit['nombre'],
            'ap_paterno' => $this->contactoEdit['paterno'],
            'ap_materno' => $this->contactoEdit['materno'],
            'ci' => $this->contactoEdit['cedula'],
            'genero' => $this->contactoEdit['genero'],
            'email' => $this->contactoEdit['email'],
        ]);
    
        $this->persona->numTelefono()->updateOrInsert(
            ['numero' => $this->contactoEdit['celular']]
        );
        session()->flash('success', 'La informacion del contacto se actualizo con éxito.');
    }

    public function render()
    {
        return view('livewire.admin.estudiante-contacto');
    }
}
