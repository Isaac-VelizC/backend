<?php

namespace Database\Seeders;

use App\Models\Persona;
use App\Models\Personal;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' =>'IsaacVeliz',
            'email' => 'isa.veliz@gmail.com',
            'password' => bcrypt('IsaacVelizAdmin'),
        ]);
        User::create([
            'name' =>'TeaganCroft',
            'email' => 'teagan.croft@gmail.com',
            'password' => bcrypt('TeaganCroft'),
        ]);
        Persona::create(['user_id' => '1', 'nombre' => 'Isak', 'ap_paterno' => 'Veliz', 'ci' => '8513398', 'genero' => 'Hombre', 'rol' => 'P']);
        Persona::create(['user_id' => '2', 'nombre' => 'Teagan', 'ap_paterno' => 'Croft', 'ci' => '6962512', 'genero' => 'Mujer', 'rol' => 'P']);
        Personal::create(['persona_id' => '2']);
        Personal::create(['persona_id' => '1']);
        
    }
}
