<?php

namespace App\Livewire\Docente;

use App\Models\NumTelefono;
use App\Models\Persona;
use App\Models\Personal;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Show extends Component
{
    public Persona $item;
    public $idDocente, $pass, $passConfirm;
    public $docenteEdit = [
        'nombre' => '',
        'paterno' => '',
        'materno' => '',
        'cedula' => '',
        'genero' => '',
        'telefono' => '',
        'email' => '',
        'cargo' => '',
    ];

    public function mount($id) {
        $this->idDocente = $id;
        $this->item = Persona::find($id);
        if (!$this->item) {
            abort(404, 'Contacto no encontrado');
        }
        $this->edit();
    }
    public function edit() {
        $this->docenteEdit['nombre'] = $this->item->nombre;
        $this->docenteEdit['paterno'] = $this->item->ap_paterno;
        $this->docenteEdit['materno'] = $this->item->ap_materno;
        $this->docenteEdit['cedula'] = $this->item->ci;
        $this->docenteEdit['genero'] = $this->item->genero;
        $this->docenteEdit['telefono'] = $this->item->numero ?? '';
        $this->docenteEdit['email'] = $this->item->email ?? $this->item->user->email;
        $this->docenteEdit['cargo'] = $this->item->personal ? $this->item->personal->cargo : '';
    }
    public function render() {
        return view('livewire.docente.show')->extends('layouts.app')
        ->section('content');
    }
    public function cambiarPassword() {
        $rules = [
            'pass' => 'required|min:8',
            'passConfirm' => 'required|same:pass',
        ];
        $this->validate($rules);
        $doc = User::find($this->item->user->id);
        $doc->password = Hash::make($this->pass);
        $doc->save();
        $this->reset(['pass', 'passConfirm']);
        session()->flash('success', 'La contraseña se actualizó con éxito.');
    }
    public function update() {
        $rules = [
            'docenteEdit.nombre' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'docenteEdit.paterno' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'docenteEdit.materno' => 'nullable|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'docenteEdit.cedula' => 'required|string|regex:/^\d{7,9}(?:-[0-9A-Z]{1,2})?$/|min:7|unique:personas,ci,' . $this->idDocente,
            'docenteEdit.genero' => 'required|in:Mujer,Hombre',
            'docenteEdit.telefono' => 'nullable|string|regex:/^[0-9+()-]{8,15}$/',
            'docenteEdit.email' => 'required|email|unique:personas,email,' . $this->idDocente,
            'docenteEdit.cargo' => 'nullable|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
        ];
        $this->validate($rules);
        try {
            $this->item->update([
                'nombre' => $this->docenteEdit['nombre'],
                'ap_paterno' => $this->docenteEdit['paterno'],
                'ap_materno' => $this->docenteEdit['materno'],
                'ci' => $this->docenteEdit['cedula'],
                'genero' => $this->docenteEdit['genero'],
                'email' => $this->docenteEdit['email'],
                'numero' => $this->docenteEdit['telefono']
            ]);
            if ($this->item->rol == 'P') {
                $rols = Personal::where('persona_id', $this->idDocente)->first();
                if (!$rols) {
                    return back()->with('success', 'Personal no encontrado.');
                }
                $rols->cargo = $this->docenteEdit['cargo'];
                $rols->save();
            }
            if ($this->item->rol == 'D') {
                User::find($this->item->user->id)->update([
                    'name' => $this->docenteEdit['cedula'], 
                    'email' => $this->docenteEdit['email'], 
                    'password' => Hash::make('igla.'. $this->docenteEdit['cedula'])
                ]);
            }
            return back()->with('success', 'La información se actualizó con éxito.');
        } catch (\Exception $e) {
            return back()->with('error', 'Hubo un problema al actualizar la información.');
        }
    }
}
