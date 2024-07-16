<?php

namespace App\Livewire\Docente;

use App\Models\Asistencia as ModelsAsistencia;
use App\Models\CursoHabilitado;
use App\Models\Estudiante;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;

class Asistencia extends Component
{
    public CursoHabilitado $materia;
    public $estudiantes, $num = 1, $fechaAsistencia, $idCurso;
    public $asistencia;

    public function mount($id) {
        $this->materia = CursoHabilitado::find($id);
        $this->idCurso = $id;
        $curso = CursoHabilitado::with('inscripciones.estudiante')->find($id);
        $this->estudiantes = $curso->inscripciones->pluck('estudiante');
        setlocale(LC_TIME, 'es_ES.utf8', 'es_ES', 'esp');
        $this->fechaAsistencia = now()->toDateString();
        $this->cargarAsistencia();
    }
    public function cargarAsistencia() {
        $asistencias = ModelsAsistencia::where('curso_id', $this->idCurso)
            ->where('fecha', $this->fechaAsistencia)->get()
            ->pluck('asistencia', 'estudiante_id')->toArray();
        $this->asistencia = count($asistencias) > 0 ? $asistencias : $this->inicializarAsistenciaPorDefecto();
    }
    public function render()
    {
        return view('livewire.docente.asistencia');
    }
    public function guardarAsistencia() {
        $this->validate([
            'fechaAsistencia' => 'required|date',
        ]);
        foreach ($this->asistencia as $estudianteId => $estado) {
            $asistenciaExistente = ModelsAsistencia::where('curso_id', $this->idCurso)
                ->where('fecha', $this->fechaAsistencia)
                ->where('estudiante_id', $estudianteId)
                ->first();
        
            if ($asistenciaExistente) {
                $asistenciaExistente->update([
                    'asistencia' => $estado,
                ]);
            } else {
                ModelsAsistencia::create([
                    'estudiante_id' => $estudianteId,
                    'curso_id' => $this->idCurso,
                    'asistencia' => $estado,
                    'fecha' => $this->fechaAsistencia,
                ]);
            }
        }
        $this->cargarAsistencia();
        $this->reset(['fechaAsistencia']);
        session()->flash('message', 'Asistencia guardada con éxito');
    }
    public function inicializarAsistenciaPorDefecto() {
        $asistenciaPorDefecto = [];
    
        foreach ($this->estudiantes as $estudiante) {
            $asistenciaPorDefecto[$estudiante->id] = 'P';
        }
    
        return $asistenciaPorDefecto;
    }
    public function exportAsistenciaPDF()
{
    try {
        $curso = CursoHabilitado::find($this->idCurso);
        Carbon::setLocale('es');
        $fechaActual = Carbon::now();
        $fecha = $fechaActual->format('d F Y');

        // Obtener todos los estudiantes del curso
        $estudiantes = Estudiante::whereHas('asistencias', function($query) {
            $query->where('curso_id', $this->idCurso);
        })->get();

        // Iterar sobre cada estudiante para calcular asistencias
        $resultados = [];
        foreach ($estudiantes as $estudiante) {
            // Obtener las asistencias del estudiante en el curso
            $asistencias = ModelsAsistencia::where('curso_id', $this->idCurso)
                                      ->where('estudiante_id', $estudiante->id)
                                      ->get();

            // Calcular los diferentes tipos de asistencias
            $presentes = $asistencias->where('asistencia', 'P')->count();
            $faltas = $asistencias->where('asistencia', 'F')->count();
            $licencias = $asistencias->where('asistencia', 'L')->count();

            // Almacenar el resultado en el array de resultados
            $resultados[] = [
                'estudiante' => $estudiante,
                'presentes' => $presentes,
                'faltas' => $faltas,
                'licencias' => $licencias,
            ];
        }

        // Preparar los datos para la vista
        $data = [
            'titulo' => 'REPORTE DE ASISTENCIAS',
            'fecha' => $fecha,
            'curso' => $curso,
            'asistencias' => $resultados,
            'i' => 1,
        ];

        // Generar el PDF
        $pdfContent = Pdf::loadView('pdf.asistencias', $data);
        return response()->streamDownload(
            function () use ($pdfContent) {
                echo $pdfContent->stream();
            },
            'reportAsistenica'. $fecha .'.pdf'
        );
    } catch (\Throwable $th) {
        session()->flash('error', 'Ocurrio un error: '. $th->getMessage());
    }
}

}
