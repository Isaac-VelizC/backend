<?php

namespace App\Imports;

use App\Models\Estudiante;
use App\Models\Persona;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EstudiantesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            // Crear o encontrar el usuario
            $user = User::firstOrCreate([
                'name' => $row['cedula']
            ], [
                'email' => $row['e_mail'],
                'password' => Hash::make('igla.' . $row['cedula'])
            ]);
            $user->assignRole('Estudiante');
    
            // Crear o encontrar la persona
            $persona = $user->persona()->create([
                'nombre' => $row['nombres'],
                'ap_paterno' => $row['primer_apellido'],
                'ap_materno' => $row['segundo_apellido'],
                'ci' => $row['cedula'],
                'genero' => $row['genero'],
                'email' => $row['e_mail'],
                'numero' => $row['numero_celular'],
            ]);
            
            // Crear el estudiante
            return new Estudiante([
                'fecha_nacimiento' => Carbon::createFromFormat('d/m/Y', $row['fecha_nacimiento'])->format('Y-m-d'),
                'persona_id' => $persona->id,
                'direccion' => $row['direccion'],
                'turno_id' => $row['horario'],
            ]);
        } catch (\Exception $e) {
            // Loguear el error para depuración
            Log::error('Error al importar fila: ' . $e->getMessage(), [
                'fila' => $row,
            ]);
    
            // Lanzar excepción personalizada
            //throw new ImportException('Error al importar la fila con cédula ' . $row['cedula'] . ': ' . $e->getMessage());
        }
    }
}
