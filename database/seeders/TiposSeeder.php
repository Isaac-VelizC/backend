<?php

namespace Database\Seeders;

use App\Models\Aula;
use App\Models\Curso;
use App\Models\FormaPago;
use App\Models\Horario;
use App\Models\MetodoPago;
use App\Models\Semestre;
use App\Models\TipoEvento;
use App\Models\TipoIngrediente;
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
        
        Semestre::create(['nombre' => 'Primer Periodo', 'descripcion' => 'Modalidad Regular', 'costo' => 450]);
        Semestre::create(['nombre' => 'Segundo Periodo', 'descripcion' => 'Modalidad Intensiva', 'costo' => 450]);
        Semestre::create(['nombre' => 'Tercer Periodo', 'descripcion' => 'Modalidad Nocturna', 'costo' => 450]);
        Semestre::create(['nombre' => 'Cuarto Periodo', 'descripcion' => 'Modalidad Fin de Semana', 'costo' => 450]);

        // Lista de materias de gastronomía
        $materias = [
            'Introducción a la Gastronomía',
            'Técnicas Culinarias',
            'Pastelería Básica',
            'Cocina Internacional',
            'Gastronomía Molecular',
            'Gestión de Restaurantes',
            'Enología y Maridaje',
            'Cocina Asiática',
            'Nutrición en la Gastronomía',
            'Cocina Italiana',
            'Cocina Vegetariana',
            'Panadería Artesanal',
            'Cocina de Autor',
            'Prácticas Profesionales',
            'Diseño de Menús',
            'Cocina Creativa',
            'Seguridad e Higiene Alimentaria',
            'Gastronomía Española',
            'Marketing Gastronómico',
        ];
        // Itera para crear registros de cursos con materias reales
        foreach ($materias as $materia) {
            Curso::create([
                'nombre' => $materia,
                'precio' => rand(200, 800), // Puedes ajustar este rango según tus necesidades
                'semestre_id' => rand(1, 4), // Suponiendo que hay 8 semestres en la carrera
                'color' => '#FFFFFF',
            ]);
        }

        $tiposIngredientes = [
            'Frutas',
            'Verduras',
            'Carnes',
            'Pescados y Mariscos',
            'Lácteos',
            'Cereales',
            'Legumbres',
            'Especias',
            'Aceites y Grasas',
            'Frutos Secos',
            'Condimentos',
            'Azúcares y Endulzantes',
            'Bebidas',
            'Otros',
        ];
        
        // Itera para crear registros de tipos de ingredientes con nombres reales
        foreach ($tiposIngredientes as $tipoIngrediente) {
            TipoIngrediente::create([
                'nombre' => $tipoIngrediente,
            ]);
        }
        
        MetodoPago::create(['nombre' => 'Cuotas', 'monto' => 450]);
        MetodoPago::create(['nombre' => 'Total', 'monto' => 5000]);
        
        FormaPago::create(['nombre' => 'Transferencia Bancaria']);
        FormaPago::create(['nombre' => 'Pago en Efectivo']);
        FormaPago::create(['nombre' => 'Pagos a Través de Aplicaciones Móviles']);

        TipoEvento::create(['nombre' => 'Clases Regulares']);
        TipoEvento::create(['nombre' => 'Fechas Límite para Inscripciones y Pago']);
        TipoEvento::create(['nombre' => 'Fechas de Inicio y Final de Períodos']);
        TipoEvento::create(['nombre' => 'Festivales y Eventos Especiales']);
    }
}
