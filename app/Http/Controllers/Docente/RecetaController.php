<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\IngredienteReceta;
use App\Models\PasosReceta;
use App\Models\Receta;
use App\Models\RecetaGenerada;
use Illuminate\Http\Request;

class RecetaController extends Controller
{
    
    public function listRecetasGeneradas() {
        try {
            $lista = RecetaGenerada::all();
            return view('docente.recetas.lista_recetas', compact('lista'));
        } catch (\Throwable $th) {
            return back()->with('error', 'Error al guardar las recetas: ' . $th->getMessage());
        }
    }

    public function showRecipeGenerate($id) {
        try {
            $recipe = RecetaGenerada::find($id);
            if (!$recipe) {
                return response()->json(['error' => 'Receta no encontrada en la base de datos'], 404);
            }
            return view('docente.recetas.components.show', compact('recipe'))->render();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al buscar receta: ' . $e->getMessage()], 500);
        }
    }
    
    public function deleteRecipeNow($id) {
        try {
            $recipe = RecetaGenerada::find($id);
            if (!$recipe) {
                return back()->with('error', 'Receta no encontrada en la base de datos');
            }
            $recipe->delete();
            return back()->with('error', 'Receta eliminada exitosamente');
        } catch (\Throwable $th) {
            return back()->with('error', 'Error al buscar receta: '. $th->getMessage());
        }
    }

}
