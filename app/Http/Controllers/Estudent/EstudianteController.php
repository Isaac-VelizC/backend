<?php

namespace App\Http\Controllers\Estudent;

use App\Http\Controllers\Controller;
use App\Models\CursoHabilitado;
use App\Models\EvalRespuestas;
use App\Models\Materia;
use App\Models\Persona;
use App\Models\Programacion;
use App\Models\RespuestaEstudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    private $idEst;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->idEst = auth()->user()->persona->estudiante->id;
            return $next($request);
        });
    }

    public function index() {
        $cursos = Programacion::where('estudiante_id', $this->idEst)->where('estado', true)->get();
        return view('estudiante.home', compact('cursos'));
    }    

    public function cursos() {
        try {
            $cursos = Programacion::where('estudiante_id', $this->idEst)->get();
            $events = $cursos->map(function ($event) {
            $trabajosPublicados = $event->cursoDocente->trabajos->where('estado', 'Publicado');
                return [
                    'id' => $event->cursoDocente->id,
                    'nombre' => $event->cursoDocente->curso->nombre,
                    'turno' => $event->cursoDocente->horario->turno,
                    'count' => count($trabajosPublicados),
                    'nota' => optional($event->cursoDocente->calificaciones->where('estudiante_id', auth()->user()->persona->estudiante->id)->first())->calificacion ?: null,
                    'color' => $event->cursoDocente->curso->color,
                ];
            });
            
            $cursosPorSemestres = Materia::select('semestres.nombre as nombre_semestre', 'materias.*')
                ->join('semestres', 'materias.semestre_id', '=', 'semestres.id')
                ->orderBy('semestres.id')
                ->get();

            $cursosProgramados = CursoHabilitado::whereHas('inscripciones', function ($query) {
                $query->where('estudiante_id', $this->idEst);
            })->get();

            return view('estudiante.cursos.index', compact('events', 'cursosPorSemestres', 'cursosProgramados'));

        } catch (\Exception $e) {
            $message = $e->getMessage();
            dd($message);
            return view('estudiante.error', compact($message));
        }
    }

    public function calificaionesMaterias() {
        $programado = Programacion::where('estudiante_id', $this->idEst)->get();
            $cursos = $programado->map(function ($event) {
                return [
                    'id' => $event->cursoDocente->id,
                    'nombre' => $event->cursoDocente->curso->nombre,
                    'nota' => optional($event->cursoDocente->calificaciones->where('estudiante_id', auth()->user()->persona->estudiante->id)->first())->calificacion ?: null,
                ];
            });
        return view('estudiante.calificaciones', compact('cursos'));
    }
    public function evaluacionDocente(Request $request) {
        try {
            $user = auth()->user()->id;
            $estudId = Persona::where('user_id', $user)->first();
            
            $request->validate([
                'respuesta.*' => 'required|in:Mal,Regular,Bueno,Muy Bueno',
                'comentario' => 'nullable|string',
                'idEvaluacion' => 'required|numeric|exists:habilitado_evaluacion,id'
            ]);
            if (is_array($request->respuesta)) {
                $item = RespuestaEstudiante::create([
                    'estudiante_id' => $estudId->estudiante->id,
                    'materia_id' => $request->idCurso,
                    'cometario' => $request->comentario ?? '',
                    'fecha' => now()
                ]);
    
                foreach ($request->respuesta as $preguntaId => $respuesta) {
                    EvalRespuestas::create([
                        'est_respt_id' => $item->id,
                        'pregunta_id' => $preguntaId,
                        'habilitado_id' => $request->idEvaluacion,
                        'texto' => $respuesta,
                        'fecha' => now(),
                    ]);
                }
                return back()->with('message', 'La evaluación al docente se realizó con éxito.');
            } else {
                return back()->with('error', 'El campo de respuestas no es un array válido.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }
}
