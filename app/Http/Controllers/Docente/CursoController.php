<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\CursoHabilitado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CursoController extends Controller
{
    public function index() {
        $idDocente = auth()->user()->persona->docente->id;
        $cursos_A = CursoHabilitado::where(['estado' => true, 'docente_id' => $idDocente ])->get();
        $cursos_I = CursoHabilitado::where(['estado' => false, 'docente_id' => $idDocente ])->get();
        return view('docente.cursos.index', compact('cursos_A', 'cursos_I'));
    }

    public function curso($id) {
        $user = Auth::user();
        $role = $user->roles->first();
        $curso = CursoHabilitado::find($id);
        return view('docente.cursos.show', compact('curso', 'role'));
    }
}
