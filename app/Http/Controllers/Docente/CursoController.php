<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Http\Controllers\InfoController;
use App\Models\CatCritTrabajo;
use App\Models\CategoriaCriterio;
use App\Models\Criterio;
use App\Models\CursoHabilitado;
use App\Models\DocumentoDocente;
use App\Models\Ingrediente;
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
        $isEditing = false;
        $temasCurso = Tema::where('curso_id', $id)->get();
        $tipoMateria = CursoHabilitado::find($id)->curso;
        $criterios = Criterio::with('categorias')->get();
        return view('docente.cursos.create_tarea', compact('temasCurso', 'tipoMateria', 'id', 'isEditing', 'criterios'));
    }

    public function selectReceta(Request $request) {
        $query = $request->input('name');
        $recetas = Receta::where('titulo', 'like', "%$query%")->get();
        return response()->json($recetas);
    }

    public function crearTarea(Request $request) {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:100',
            'fin' => ['date', 'after_or_equal:' . now()->toDateString()],
            'tipo_trabajo' => 'required|string|max:255',
            'tema' => 'nullable|numeric|exists:temas,id',
            'con_nota' => 'required|boolean',
            'evaluacion' => 'required|boolean',
            'tags.*' => 'exists:ingredientes,id',
            'recetas' => 'exists:recetas,id',
            'files.*' => 'file',
            'criterio' => 'required|numeric|'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            
            if ($request->criterio != null && $request->tipo_categoria == 'Crit') {
                $criterioId  = $request->criterio;
            } else {
                $categoryCriterio = CategoriaCriterio::find($request->criterio);
                $criterioId = $categoryCriterio->criterio_id;
            }

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
                'estado' => 'Publicado',
                'criterio_id' => $criterioId,
            ]);

            if ($request->tipo_categoria == 'Cat') {
                CatCritTrabajo::create([
                    'cat_id' => $request->criterio,
                    'tarea_id' => $tarea->id
                ]);
            }

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
            $message = "Titulo: " . $tarea->titulo . ", Fecha de entrega " . $tarea->fin . ".";
            InfoController::notificacionTrabajoPublicado($request->curso, $message);
            return redirect()->route('cursos.curso', $request->curso)->with('success', 'Trabajo publicado con éxito');
        } catch (\Throwable $th) {
            return back()->with(['error' => 'Error al crear el evento', 'error' => $th->getMessage()], 500);
        }
    }
    public function editarTareaEdit($idTrabajo) {
        $trabajo = Trabajo::find($idTrabajo);
        $ingredientes = json_decode($trabajo->ingredientes, true);
    
        $ingrests = [];
        if ($ingredientes) {
            foreach ($ingredientes as $key => $value) {
                $ingrests[] = Ingrediente::find($value);
            }
        }
        $isEditing = true;
        $temasCurso = Tema::where('curso_id', $trabajo->curso_id)->get();
        $files = DocumentoDocente::where('tarea_id', $idTrabajo)->get();
        $id = $trabajo->curso_id;
        $criterios = Criterio::with('categorias')->get();
        $tipoMateria = CursoHabilitado::find($id)->curso;
        return view('docente.cursos.create_tarea', compact('temasCurso', 'tipoMateria', 'isEditing', 'files', 'id', 'trabajo', 'ingrests', 'criterios'));
    }
    
    public function updateTrabajo(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'fin' => ['date', 'after_or_equal:' . now()->toDateString()],
            'tipo_trabajo' => 'required|string|max:255',
            'tema' => 'nullable|numeric|exists:temas,id',
            'con_nota' => 'required|boolean',
            'evaluacion' => 'required|boolean',
            'tags.*' => 'exists:ingredientes,id',
            'recetas' => 'exists:recetas,id',
            'files.*' => 'file',
            'criterio' => 'required|numeric|'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            if ($request->criterio != null && $request->tipo_categoria == 'Crit') {
                $criterioId  = $request->criterio;
            } else {
                $categoryCriterio = CategoriaCriterio::find($request->criterio);
                $criterioId = $categoryCriterio->criterio_id;
            }

            $tarea = Trabajo::find($id)->update([
                'tipo' => $request->tipo_trabajo,
                'tema_id' => $request->tema ?: null,
                'ingredientes' => json_encode($request->tags) ?: null,
                'receta_id' => $request->recetas ?: null,
                'evaluacion' => $request->evaluacion,
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'inico' => now(),
                'fin' => $request->fin,
                'con_nota' => $request->con_nota,
                'criterio_id' => $criterioId,
            ]);

            $catCritTrabajo = CatCritTrabajo::where('tarea_id', $id)->first();
            if ($catCritTrabajo) {
                if ($request->tipo_categoria == 'Cat') {
                    $catCritTrabajo->update([
                        'cat_id' => $request->criterio,
                    ]);
                } else {
                    $catCritTrabajo->delete();
                }
            } else if ($request->tipo_categoria == 'Cat') {
                CatCritTrabajo::create([
                    'cat_id' => $request->criterio,
                    'tarea_id' => $id
                ]);
            }

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
            return redirect()->route('cursos.curso', $request->curso)->with('success', 'Trabajo actualizado con éxito');
        } catch (\Throwable $th) {
            return back()->with(['error' => 'Error al actualizar el trabajo', 'error' => $th->getMessage()], 500);
        }
    }
    public function borrarFile($id) {
        try {
            DocumentoDocente::find($id)->delete();
            return back();
        } catch (\Throwable $th) {
            return back()->with(['error' => 'Error al borrar el archivo', 'error' => $th->getMessage()], 500);
        }
    }

    public function viewTemeEdit($id) {
        $tema = Tema::find($id);
        return view('docente.cursos.edit_tema', compact('tema'));
    }
    public function updateTema(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|min:5',
            'descripcion' => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $item = Tema::find($id);
            if ($item) {
                $item->update([
                    'tema' => $request->nombre,
                    'descripcion' => $request->descripcion
                ]);

                return redirect()->route('cursos.curso', $item->curso_id);
            } else {
                // Manejar el caso en que no se encuentre el tema con el ID dado
                return back()->with('error', 'El tema no fue encontrado.');
            }
        } catch (\Throwable $th) {
            return back()->with(['error' => 'Error al crear el evento', 'error' => $th->getMessage()], 500);
        }
    }
}
