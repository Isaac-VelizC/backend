<?php

namespace App\Livewire\Admin;

use App\Models\EvaluacionDocente as ModelsEvaluacionDocente;
use App\Models\PreguntaEvaluacionDocente;
use Livewire\Component;

class EvaluacionDocente extends Component
{
    public $textPregunta, $preguntas, $idPreguntaEdicion;
    public PreguntaEvaluacionDocente $pregunta;
    public $modoEdicion = false;

    public function mount() {
        $this->preguntas = PreguntaEvaluacionDocente::all();
    }

    public function render()
    {
        return view('livewire.admin.evaluacion-docente')->extends('layouts.app')
        ->section('content');
    }

    public function seleccionPregunta($id) {
        try {
            if ($id) {
                $this->idPreguntaEdicion = $id;
                $pregunta = PreguntaEvaluacionDocente::find($id);
                $this->textPregunta = $pregunta->texto;
                $this->modoEdicion = true;
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al realizar la operación: ' . $e->getMessage());
        }
    }

    public function cancelar() {
        $this->idPreguntaEdicion = '';
        $this->reset(['textPregunta', 'modoEdicion']);
        $this->mount();
    }

    public function guardar() {
        $data = $this->validate([
            'textPregunta' => 'required|string',
        ]);
    
        try {
            if ($this->modoEdicion) {
                $pregunta = PreguntaEvaluacionDocente::find($this->idPreguntaEdicion);
                $pregunta->update(['texto' => $this->textPregunta]);
            } else {
                $registro = ModelsEvaluacionDocente::first();
                if (!$registro) {
                    $eval = ModelsEvaluacionDocente::create([
                        'codigo' => '6962IGLAEVALDOC',
                    ]);
                    $this->preguntaGuardada($eval->id);
                } else {
                    $this->preguntaGuardada($registro->id);
                }
            }
            $this->cancelar();
            session()->flash('message', 'Pregunta guardada con éxito.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al realizar la operación: ' . $e->getMessage());
        }
    }

    public function preguntaGuardada($id) {
        $ultimoNumero = PreguntaEvaluacionDocente::latest('numero')->value('numero') ?? 0;
        $numero = $ultimoNumero + 1;
        PreguntaEvaluacionDocente::create([
            'texto' => $this->textPregunta,
            'numero' => $numero,
            'id_evaluacion' => $id,
        ]);
    }

    public function borrar() {
        try {
            if ($this->idPreguntaEdicion) {
                PreguntaEvaluacionDocente::destroy($this->idPreguntaEdicion);
    
                $preguntas = PreguntaEvaluacionDocente::all();
                $i = 1;
                foreach ($preguntas as $pregunta) {
                    $pregunta->numero = $i;
                    $pregunta->save();
                    $i++;
                }
                $this->dispatch('success', ['message'=> 'Pregunta borrada con éxito!']);
                session()->flash('message', 'Pregunta borrada con éxito.');
                $this->cancelar();
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al realizar la operación: ' . $e->getMessage());
        }
    }
}
