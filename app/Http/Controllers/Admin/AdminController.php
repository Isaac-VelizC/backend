<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    public function index() {
        $users = User::all();
        $estudiantes = Estudiante::all();
        $docentes = Docente::all();
        $materias = Curso::all();

        // Devuelve los datos en formato JSON
        return new JsonResponse([
            'users' => $users,
            'estudiantes' => $estudiantes,
            'docentes' => $docentes,
            'materias' => $materias,
        ]);
    }
}
