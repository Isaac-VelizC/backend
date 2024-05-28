<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\CursoHabilitado;
use App\Models\Receta;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function index() {
        $iddocente =  auth()->user()->persona->docente->id;
        $cursos = CursoHabilitado::where('docente_id', $iddocente)->get();
        $recetas = Receta::all();
        $misRecetas = []; /*Receta::where('docente_id', auth()->user()->id)
        ->latest()  // Ordenar por el campo creado más reciente
        ->limit(10) // Obtener solo los últimos 10 registros
        ->get();*/
        $materiasA = CursoHabilitado::where(['estado' => true, 'docente_id' => $iddocente ])->get();
        return view('docente.home', compact('cursos', 'recetas', 'misRecetas', 'materiasA'));
    }
    public function planificacion(Request $request, $id) {
        $request->validate([
            'imagen' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);        
        try {
            $curso = CursoHabilitado::find($id);
            $curso->descripcion = $request->planificacion;
            if ($request->imagen) {
                $path = $request->imagen->store('public/files');
                $path = str_replace('public/', '', $path);
                $curso->imagen = 'storage/'.$path;
            }
            $curso->update();
    
            return back()->with('message', 'Planificacion guardada');
        } catch (\Exception $e) {
            return back()->with('message', 'Error al guardar la planificacion');
        }
    }
}
