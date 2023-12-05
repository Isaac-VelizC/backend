<?php

namespace App\Http\Controllers\Estudent;

use App\Http\Controllers\Controller;
use App\Models\Programacion;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function index() {
        return view('estudiante.home');
    }

    public function cursos() {
        $cursos = Programacion::where('estudiante_id', auth()->user()->persona->estudiante->id)->get();
        return view('estudiante.cursos.index', compact('cursos'));
    }
}
