<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingrediente;
use App\Models\Receta;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CocinaController extends Controller
{
    public function allIngredientes() {
        $recetas = Receta::all();
        return view('admin.recetas.ingredientes.index', compact('recetas'));
    }
    public function allrecetas() {
        return view('admin.recetas.index');
    }
    public function selectIngredientes(Request $request) {
        $tags = [];
        if ($search = $request->name) {
            $tags = Ingrediente::where('nombre', 'LIKE', "%$search%")->get();
        }
        return response()->json($tags);
    }
    public function buscarIngredientes(Request $request)
    {
        $nombre = $request->input('nombre');

        return cache()->remember('resultados_' . $nombre, 3600, function () use ($nombre) {
            return Ingrediente::where('nombre', 'like', '%' . $nombre . '%')->paginate(25);
        });
    }
    public function showReceta($id) {
        $receta = Receta::find($id);
        return view('docente.recetas.show', compact('receta'));
    }
    public function deleteReceta($id) {
        try {
            $receta = Receta::findOrFail($id);
            $receta->pasos()->delete();
            $receta->ingredientesReceta()->delete();
            $receta->delete();
            return back()->with('success', 'Receta eliminada con éxito');
        } catch (ModelNotFoundException $e) {
            // Manejar la excepción si la receta no se encuentra
            return back()->with('error', 'La receta no fue encontrada');
        } catch (\Exception $e) {
            // Manejar otras excepciones
            return back()->with('error', 'Error al eliminar la receta: ' . $e->getMessage());
        }
    }

}
