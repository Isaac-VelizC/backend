<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\CursoHabilitado;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function index() {
        $cursos = CursoHabilitado::where('docente_id', auth()->user()->persona->docente->id)->get();
        return view('docente.home', compact('cursos'));
    }
    public function planificacion(Request $request, $id) {
        try {
            $curso = CursoHabilitado::find($id);
            $curso->descripcion = $request->planificacion;
            $curso->update();
    
            return back()->with('message', 'Planificacion guardada');
        } catch (\Exception $e) {
            return back()->with('message', 'Error al guardar la planificacion');
        }
    }
}
