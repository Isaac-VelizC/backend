<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingrediente;
use Illuminate\Http\Request;

class CocinaController extends Controller
{
    public function allIngredientes() {
        return view('admin.recetas.ingredientes.index');
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
}
