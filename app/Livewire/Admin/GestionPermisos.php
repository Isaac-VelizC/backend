<?php

namespace App\Livewire\Admin;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GestionPermisos extends Component
{
    public $permisos, $roles, $permisosRoles = [];
    public $rolNew, $permisoNew;

    public function mount() {
        $this->roles = Role::all();
        $this->permisos = Permission::all();
        foreach ($this->roles as $role) {
            foreach ($this->permisos as $permiso) {
                $this->permisosRoles[$role->id][$permiso->id] = $role->hasPermissionTo($permiso);
            }
        }
    }
    public function render()
    {
        return view('livewire.admin.gestion-permisos')->extends('layouts.app')->section('content');
    }
    public function savePermissions() {
        foreach ($this->roles as $role) {
            $permissionsToSync = [];
            foreach ($this->permisos as $permiso) {
                if ($this->permisosRoles[$role->id][$permiso->id]) {
                    $permissionsToSync[] = $permiso->id;
                }
            }
            $role->syncPermissions($permissionsToSync);
        }
        $this->mount();
    }
    public function createNewRol() {
        $this->validate([
            'rolNew' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')],
        ]);

        try {
            Role::create(['name' => $this->rolNew]);
            $this->mount();

            session()->flash('message', 'El nuevo rol se creó con éxito.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al crear el nuevo rol: ' . $e->getMessage());
        }
    }

    public function createNewPermiso() {
        $this->validate([
            'permisoNew' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')],
        ]);

        try {
            Permission::create(['name' => $this->permisoNew]);
            $this->mount();

            session()->flash('message', 'El nuevo permiso se creó con éxito.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al crear el nuevo permiso: ' . $e->getMessage());
        }
    }
    public function cancelarForm() {
        $this->rolNew = '';
        $this->permisoNew = '';
    }
    public function deleteRol($rolId) {
        $rol = Role::findOrFail($rolId);
        $rol->delete();
        $this->mount();

        session()->flash('message', 'El rol se eliminó con éxito.');
    }
    public function deletePermiso($permisoId) {
        $permiso = Permission::findOrFail($permisoId);
        $permiso->delete();
        $this->mount();

        session()->flash('message', 'El permiso se eliminó con éxito.');
    }
}
