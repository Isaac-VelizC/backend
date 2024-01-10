<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Persona;
use App\Models\User;

class AdminController extends Controller
{
    public function allUsers() {
        $users = Persona::join('users', 'personas.user_id', '=', 'users.id')->select('personas.*')->get();
        return view('admin.usuarios.lista_users', compact('users'));
    }   
    public function index() {
        $users = User::all();
        $estudiantes = Estudiante::all();
        $docentes = Docente::all();
        $materias = Curso::all();
        return view('admin.home', compact('users', 'estudiantes', 'docentes', 'materias'));
    }
}