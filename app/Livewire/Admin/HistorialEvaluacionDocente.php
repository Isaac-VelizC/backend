<?php

namespace App\Livewire\Admin;

use App\Models\CursoHabilitado;
use App\Models\EvaluacionHabilitada;
use App\Models\RespuestaEstudiante;
use Livewire\Component;

class HistorialEvaluacionDocente extends Component
{
    public $materiasHabilitados, $MateriaSeleccionada, $materiaNombre;
    public $respuestas = false;
    public $conteoRespuestas = [];
    public $porcentajes = []; // Agrega esta línea

    public function mount() {
        $this->materiasHabilitados = EvaluacionHabilitada::all();
        $this->porcentajes = []; // Asegúrate de inicializar $porcentajes
    }
    
    public function render()
    {
        return view('livewire.admin.historial-evaluacion-docente')->extends('layouts.app')->section('content');
    }

    public function seleccionarMateria($id) {
        try {
            $respuestasEstudiantes = RespuestaEstudiante::with('evalRespuestas.pregunta')
                ->where('materia_id', $id)
                ->get();
            $this->materiaNombre = CursoHabilitado::find($id)->curso->nombre;
            $this->procesarRespuestas($respuestasEstudiantes);
            $this->calcularPorcentajes();
            $this->respuestas = true;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            session()->flash('error', 'La materia no fue encontrada.');
        } catch (\Exception $e) {
            report($e);
            session()->flash('error', 'Ocurrió un error al seleccionar: ' . $e->getMessage());
        }
    }

    private function procesarRespuestas($respuestasEstudiantes) {
        foreach ($respuestasEstudiantes as $respuestaEstudiante) {
            $evalRespuestas = $respuestaEstudiante->evalRespuestas;
            foreach ($evalRespuestas as $evalRespuesta) {
                $pregunta = $evalRespuesta->pregunta;
                if ($pregunta) {
                    $preguntaId = $pregunta->id;
                    $tipoRespuesta = $evalRespuesta->texto;

                    if (!isset($this->conteoRespuestas[$preguntaId][$tipoRespuesta])) {
                        $this->conteoRespuestas[$preguntaId][$tipoRespuesta] = 1;
                    } else {
                        $this->conteoRespuestas[$preguntaId][$tipoRespuesta]++;
                    }
                }
            }
        }
    }

    private function calcularPorcentajes() {
        foreach ($this->conteoRespuestas as $preguntaId => $tiposRespuestas) {
            $totalRespuestas = array_sum($tiposRespuestas);

            foreach ($tiposRespuestas as $tipoRespuesta => $conteo) {
                $porcentaje = ($conteo / $totalRespuestas) * 100;
                $this->porcentajes[$preguntaId][$tipoRespuesta] = round($porcentaje, 2);
            }
        }
    }
}
