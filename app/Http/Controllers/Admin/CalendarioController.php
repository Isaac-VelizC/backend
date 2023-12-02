<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\TipoEvento;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    public function index() {
        $categorias = TipoEvento::all();
        return view('admin.calendario.index', compact('categorias'));
    }
    public function store(Request $request) {
        try {
            request()->validate(Evento::$rules);
    
            Evento::create([
                'responsable_id' => auth()->user()->id,
                'tipo_id' => $request->tipo_id,
                'start' => $request->start,
                'end' => $request->end,
                'title' => $request->title,
                'descripcion' => $request->descripcion
            ]);
    
            return response()->json(['message' => 'Evento creado con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el evento', 'error' => $e->getMessage()], 500);
        }
    }
    public function edit($id) {
        $event = Evento::find($id);
        $event->start = Carbon::createFromFormat('Y-m-d H:i:s', $event->start)->format('Y-m-d');
        $event->end = Carbon::createFromFormat('Y-m-d H:i:s', $event->end)->format('Y-m-d');
        return response()->json($event);
    }
    public function update(Request $request, $id) {
        try {
            request()->validate(Evento::$rules);
            $evento = Evento::find($id);
            $evento->update([
                'responsable_id' => auth()->user()->id,
                'tipo_id' => $request->tipo_id,
                'start' => $request->start,
                'end' => $request->end,
                'title' => $request->title,
                'descripcion' => $request->descripcion
            ]);
    
            return response()->json(['message' => 'Evento actualizado con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el evento', 'error' => $e->getMessage()], 500);
        }
    }
    public function delete($id) {
        try {
            Evento::find($id)->delete();
            return response(['message' => 'Evento eliminado con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el evento', 'error' => $e->getMessage()], 500);
        }
    }
    public function show($id) {
        dd($id);
    }
    public function mostrar() {
        try {
            $events = Evento::with('tipo')->get();
            $events = $events->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start,
                    'end' => $event->end,
                    'descripcion' => $event->descripcion,
                    'tipo_id' => $event->tipo_id,
                    'backgroundColor' => $event->tipo->backgroundColor,
                    'textColor' => $event->tipo->textColor,
                ];
            });
            return response()->json($events);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
