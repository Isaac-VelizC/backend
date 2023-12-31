<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Http\Controllers\InfoController;
use App\Models\CursoHabilitado;
use App\Models\DocumentoDocente;
use App\Models\Receta;
use App\Models\Tema;
use App\Models\Trabajo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        return view('docente.cursos.create_tarea', compact('temasCurso', 'id'));
    }
    public function selectReceta(Request $request) {
        $query = $request->input('name');
    
        $recetas = Receta::where('titulo', 'like', "%$query%")->get();
    
        return response()->json($recetas);
    }

    public function crearTarea(Request $request) {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'fin' => ['date', 'after_or_equal:' . now()->toDateString()],
            'tipo_trabajo' => 'required|string|max:255',
            'tema' => 'nullable|numeric',
            'con_nota' => 'required|boolean',
            'evaluacion' => 'required|boolean',
            'tags.*' => 'exists:ingredientes,id',
            'recetas' => 'exists:recetas,id',
            'files.*' => 'file'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $tarea = Trabajo::create([
                'tipo' => $request->tipo_trabajo,
                'curso_id' => $request->curso,
                'user_id' => auth()->user()->id,
                'tema_id' => $request->tema ?: null,
                'ingredientes' => json_encode($request->tags) ?: null,
                'receta_id' => $request->recetas ?: null,
                'evaluacion' => $request->evaluacion,
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'inico' => now(),
                'fin' => $request->fin,
                'con_nota' => $request->con_nota,
                'nota' => 100,
                'estado' => 'Publicado'
            ]);

            $files = $request->file('files');
            if ($files) {
                foreach ($files as $file) {
                    $originalName = $file->getClientOriginalName();
                    $filePath = $file->storeAs('public/files', $originalName);
                    $url = str_replace('public/', '', $filePath);
                    DocumentoDocente::create([
                        'nombre' => $originalName,
                        'url' => 'storage/'.$url,
                        'fecha' => now(),
                        'materia_id' => $request->curso,
                        'user_id' => auth()->user()->id,
                        'tarea_id' => $tarea->id
                    ]);
                }
            }
            //$ruta = route('show.tarea', $tarea->id);
            $message = "Titulo: " . $tarea->titulo . ", Fecha de entrega " . $tarea->fin . ".";
            InfoController::notificacionTrabajoPublicado($request->curso, $message);
            return redirect()->route('cursos.curso', $request->curso)->with('success', 'Trabajo publicado con éxito');
        } catch (\Throwable $th) {
            return back()->with(['error' => 'Error al crear el evento', 'error' => $th->getMessage()], 500);
        }
    }
}
