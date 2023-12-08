<?php

namespace Database\Seeders;

use App\Models\Aula;
use App\Models\Horario;
use App\Models\MetodoPago;
use App\Models\Semestre;
use App\Models\TipoEvento;
use App\Models\TipoTrabajo;
use Illuminate\Database\Seeder;

class TiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Horario::create(['turno' => 'Mañana', 'inicio' => '08:00', 'fin' => '12:00']);
        Horario::create(['turno' => 'Tarde', 'inicio' => '14:00', 'fin' => '18:00']);
        Horario::create(['turno' => 'Noche', 'inicio' => '19:00', 'fin' => '22:30']);
        Horario::create(['turno' => 'Sabado', 'inicio' => '08:00', 'fin' => '12:00']);

        Aula::create(['nombre' => 'Aula de Cocina 101', 'codigo' => 'GA101', 'capacidad' => 25]);
        Aula::create(['nombre' => 'Aula de Pastelería 201', 'codigo' => 'GP201', 'capacidad' => 20]);
        Aula::create(['nombre' => 'Laboratorio de Enología 301', 'codigo' => 'GE301', 'capacidad' => 30]);
        Aula::create(['nombre' => 'Sala de Degustación 401', 'codigo' => 'GD401', 'capacidad' => 15]);
        Aula::create(['nombre' => 'Aula de Panadería 501', 'codigo' => 'GP501', 'capacidad' => 25]);
        
        Semestre::create(['nombre' => 'Primer Semestre', 'descripcion' => 'Modalidad Regular', 'costo' => 500]);
        Semestre::create(['nombre' => 'Segundo Semestre', 'descripcion' => 'Modalidad Intensiva', 'costo' => 600]);
        Semestre::create(['nombre' => 'Tercer Semestre', 'descripcion' => 'Modalidad Nocturna', 'costo' => 550]);
        Semestre::create(['nombre' => 'Cuarto Semestre', 'descripcion' => 'Modalidad Fin de Semana', 'costo' => 700]);

        TipoTrabajo::create(['nombre' => 'Teorica']);
        TipoTrabajo::create(['nombre' => 'Practica']);
        
        MetodoPago::create(['nombre' => 'Cuotas']);
        MetodoPago::create(['nombre' => 'Todo']);

        TipoEvento::create(['nombre' => 'Clases Regulares']);
        TipoEvento::create(['nombre' => 'Fechas Límite para Inscripciones y Pago']);
        TipoEvento::create(['nombre' => 'Fechas de Inicio y Final de Períodos']);
        TipoEvento::create(['nombre' => 'Festivales y Eventos Especiales']);
    }
}
