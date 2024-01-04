<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\CursoHabilitado;
use App\Models\Receta;
use App\Models\Tema;
use App\Models\TipoTrabajo;
use App\Models\Trabajo;
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
    public function createTareaNew($id) {
        $temasCurso = Tema::where('curso_id', $id)->get();
        $tipoTrabajo = TipoTrabajo::all();

        return view('docente.cursos.create_tarea', compact('temasCurso', 'tipoTrabajo', 'id'));
    }
    public function selectReceta(Request $request) {
        $query = $request->input('name');
    
        $recetas = Receta::where('titulo', 'like', "%$query%")->get();
    
        return response()->json($recetas);
    }
    public function crearTarea(Request $request) {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'fin' => ['date', 'after_or_equal:' . now()->toDateString()],
            'tipo_trabajo' => 'required|string|max:255',
        ]);
        dd('error');
        try {
            dd($request);
            $trabajo = Trabajo::create([
                'tipo_id' => '',
                'curso_id' => $request->curso,
                'user_id' => auth()->user()->id,
                'tema_id' => $request->tema,
                'ingrediente_id' => '',
                'receta_id' => '',
                'evaluacion' => '',
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'inico' => now(),
                'fin' => $request->fin,
                'con_nota' => $request->con_nota,
                'nota' => $request->nota,
            ]);
            return back()->with('');
        } catch (\Throwable $th) {
            return back()->with(['error' => 'Error al crear el evento', 'error' => $th->getMessage()], 500);
        }
    }
    public function tareaAutomatico(Request $request) {
        // Valida los datos del formulario
        $request->validate([
            'titulo' => 'required|string|max:255',
            'idCurso' => 'required|numeric', // Ajusta la validación según tus necesidades
        ]);
        $tarea = Trabajo::create([
            'curso_id' => $request->idCurso,
            'user_id' => auth()->user()->id,
            'titulo' => $request->titulo,
        ]);
    
        // Devuelve el ID de la tarea creada
        return response()->json(['id' => $tarea->id]);
    }
}
