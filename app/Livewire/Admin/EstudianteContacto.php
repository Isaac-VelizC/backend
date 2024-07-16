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
    public $isEditing = false;
    public $contactId = '', $idEstudiante, $estado;

    public $contactoEdit = [
        'nombre' => '',
        'paterno' => '',
        'materno' => '',
        'cedula' => '',
        'genero' => '',
        'celular' => '',
        'email' => '',
    ];

    public function mount(Estudiante $estudiante) {
        $this->estado = $estudiante->estado;
        if ($estudiante->contact_id != null) {
            $contacto = Contacto::find($estudiante->contact_id);
            $this->contactId = $contacto->id;
            $this->persona = Persona::find($contacto->persona_id);
            $this->edit();
        } else {
            $this->persona = new Persona();
            $this->idEstudiante = $estudiante->id;
        }
    }

    public function edit() {
        $this->contactoEdit['nombre'] = $this->persona->nombre;
        $this->contactoEdit['paterno'] = $this->persona->ap_paterno;
        $this->contactoEdit['materno'] = $this->persona->ap_materno;
        $this->contactoEdit['cedula'] = $this->persona->ci;
        $this->contactoEdit['genero'] = $this->persona->genero;
        $this->contactoEdit['celular'] = $this->persona->numero;  
        $this->contactoEdit['email'] = $this->persona->email;
        $this->isEditing = true;
    }

    public function update() {
        $rules = [
            'contactoEdit.nombre' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'contactoEdit.paterno' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'contactoEdit.materno' => 'nullable|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'contactoEdit.cedula' => 'required|string|regex:/^\d{7,9}(?:-[0-9A-Z]{1,2})?$/|min:7|unique:personas,ci,' . $this->persona->id,
            'contactoEdit.genero' => 'required|in:Mujer,Hombre,Otro',
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
            'numero' => $this->contactoEdit['celular']
        ]);
        session()->flash('success', 'La informacion del contacto se actualizo con éxito.');
    }

    public function store() {
        try {
            $rules = [
                'contactoEdit.nombre' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
                'contactoEdit.paterno' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
                'contactoEdit.materno' => 'nullable|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
                'contactoEdit.cedula' => 'required|string|regex:/^\d{7,9}(?:-[0-9A-Z]{1,2})?$/|min:7|unique:personas,ci',
                'contactoEdit.genero' => 'required|in:Mujer,Hombre,Otro',
                'contactoEdit.email' => 'nullable|email|unique:personas,email',
            ];
            $this->validate($rules);
            // Crear una nueva persona para el contacto
            $persona = Persona::create([
                'nombre' => $this->contactoEdit['nombre'],
                'ap_paterno' => $this->contactoEdit['paterno'],
                'ap_materno' => $this->contactoEdit['materno'],
                'ci' => $this->contactoEdit['cedula'],
                'genero' => $this->contactoEdit['genero'],
                'email' => $this->contactoEdit['email'],
                'numero' => $this->contactoEdit['celular']
            ]);
            // Crear un nuevo contacto asociado a la persona
            $contac = $persona->contacto()->create();
            // Actualizar el ID del contacto en el estudiante
            Estudiante::find($this->idEstudiante)->update(['contact_id' => $contac->id]);
            $this->isEditing = false;
            return back()->with('success', 'La información se actualizó con éxito.');
        } catch (\Exception $e) {
            session()->flash('error', 'Hubo un error al procesar la solicitud: ' . $e->getMessage());
        }
    }
    

    public function render()
    {
        return view('livewire.admin.estudiante-contacto');
    }
}
