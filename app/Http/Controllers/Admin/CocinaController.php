<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingrediente;
use App\Models\Receta;
use App\Models\TipoIngrediente;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CocinaController extends Controller
{
    public function allIngredientes() {
        $recetas = Receta::all();
        $types = TipoIngrediente::all();
        return view('admin.recetas.ingredientes.index', compact('recetas', 'types'));
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
    public function guardarIngrediente(Request $request) {
        try {
            $this->validate($request, [
                'nombre' => 'required|string|max:255|unique:ingredientes,nombre',
                'tipo' => 'required|numeric',
            ]);
            $ingre = new Ingrediente();
            $ingre->nombre = $request->nombre;
            $ingre->tipo_id = $request->tipo;
            $ingre->save();
            return back()->with('success', 'Se registro con éxito.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Error al registrar: ' . $th->getMessage());
        }
    }

}
