<?php

namespace App\Http\Controllers\Estudent;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\CursoHabilitado;
use App\Models\Programacion;
use DateTime;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    private $idEst;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->idEst = auth()->user()->persona->estudiante->id;
            return $next($request);
        });
    }

    public function index() {
        return view('estudiante.home');
    }

    public function cursos() {
        try {
            $cursos = Programacion::where('estudiante_id', $this->idEst)->get();
            $events = $cursos->map(function ($event) {
                try {
                    $trabajosPublicados = $event->cursoDocente->trabajos->where('estado', 'Publicado');
                    $fechaInicio = new DateTime($event->cursoDocente->fecha_ini);
                    $fechaFin = new DateTime($event->cursoDocente->fecha_fin);
                    $fechaActual = new DateTime();
                    if ($fechaActual >= $fechaInicio && $fechaActual <= $fechaFin) {
                        $diferenciaTotal = $fechaFin->diff($fechaInicio)->days;
                        $diferenciaActual = $fechaActual->diff($fechaInicio)->days;
                        $porcentaje = ($diferenciaActual / $diferenciaTotal) * 100;
                    } else {
                        $porcentaje = 0;
                    }
                } catch (\Exception $e) {
                    $porcentaje = 0;
                }

                return [
                    'id' => $event->cursoDocente->id,
                    'nombre' => $event->cursoDocente->curso->nombre,
                    'turno' => $event->cursoDocente->horario->turno,
                    'count' => count($trabajosPublicados),
                    'nota' => optional($event->cursoDocente->calificaciones->where('estudiante_id', auth()->user()->persona->estudiante->id)->first())->calificacion ?: null,
                    'porcentaje' => $porcentaje
                ];
            });

            $cursosPorSemestres = Curso::select('semestres.nombre as nombre_semestre', 'cursos.*')
                ->join('semestres', 'cursos.semestre_id', '=', 'semestres.id')
                ->orderBy('semestres.id')
                ->get();

            $cursosProgramados = CursoHabilitado::whereHas('inscripciones', function ($query) {
                $query->where('estudiante_id', $this->idEst);
            })->get();

            return view('estudiante.cursos.index', compact('events', 'cursosPorSemestres', 'cursosProgramados'));

        } catch (\Exception $e) {
            return view('estudiante.error');
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
}
