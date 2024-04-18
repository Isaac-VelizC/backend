<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoriaCriterio;
use App\Models\Configuration;
use App\Models\Criterio;
use Illuminate\Http\Request;

class CriterioController extends Controller
{
    public function index() {
        $criterios = Criterio::all();
        $ponderacion = Configuration::find(1)->ponderacion;
        return view('admin.cursos.criterios.index', compact('criterios', 'ponderacion'));
    }

    public function criteroAdd(Request $request) {
        try {
            $rules = [
                'nombre' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
                'porcentaje' => 'required|numeric|min:5|max:100',
                'ponderacion_hidden' => 'required|numeric|max:100|min:0',
            ];
            $request->validate($rules);
            Criterio::create([
                'nombre' => $request->nombre,
                'porcentaje' => $request->porcentaje,
                'total' => $request->porcentaje,
            ]);
            Configuration::find(1)->update(['ponderacion' => $request->ponderacion_hidden ]);
            return back()->with('success', 'Criterio guardado con exito');
        } catch (\Throwable $th) {
            return back()->with('error', 'Error: '. $th->getMessage());
        }
    }

    public function pageCriteroUpdate($id) {
        $criterio = Criterio::find($id);
        $ponderacion = Configuration::find(1)->ponderacion;
        if (!$criterio || !$ponderacion) {
            return back()->with('success', 'Criterio o ponderacion no encontrado');
        }
        return view('admin.cursos.criterios.edit', compact('criterio', 'ponderacion'));
    }

    public function criteroUpdate(Request $request, $id) {
        try {
            $rules = [
                'nombre' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
                'porcentaje' => 'required|numeric|min:5|max:100',
                'ponderacion_hidden' => 'required|numeric|max:100|min:0',
            ];
            $request->validate($rules);
            $criterio = Criterio::find($id);
            if ($criterio) {
                if ($criterio->categorias()->exists()) {
                    $total = CategoriaCriterio::where('criterio_id', $id)->sum('porcentaje');
                    if ($request->porcentaje < $total) {
                        return back()->with('error', 'El valor de '. $request->porcentaje .' no puede ser menor al total que se esta usando en los demas categorias que es de '. $total);
                    }
                    $criterio->total = $request->porcentaje - $total;
                } else {
                    $criterio->total = $request->porcentaje;
                }
                $criterio->nombre = $request->nombre;
                $criterio->porcentaje = $request->porcentaje;

                $criterio->save();
                Configuration::find(1)->update(['ponderacion' => $request->ponderacion_hidden ]);
                return redirect()->route('admin.tareas.criterios')->with('success', 'Criterio actualizado con exito');
            } else {
                return back()->with('error', 'Criterio no encontrado.');
            }
        } catch (\Throwable $th) {
            return back()->with('error', 'Error: '. $th->getMessage());
        }
    }
    
    public function criterioDelete($id) {
        try {
            $crit = Criterio::find($id);
            
            // Verificar si el criterio tiene relaciones con trabajos o categorías
            if ($crit->trabajos()->exists() || $crit->categorias()->exists()) {
                // Si tiene relaciones, no se puede borrar
                return back()->with('error', 'No se puede borrar el criterio porque tiene relaciones con trabajos o categorías.');
            }
            // También puedes borrar la ponderación en Configuration si lo deseas
            $ponde = Configuration::find(1);
            $ponde->ponderacion = $ponde->ponderacion + $crit->porcentaje;
            $ponde->save();
            // Si no tiene relaciones, se puede borrar
            $crit->delete();
    
            return back()->with('success', 'El criterio se borró exitosamente');
        } catch (\Throwable $th) {
            return back()->with('error', 'Error: '. $th->getMessage());
        }
    }

    public function pageCriteroCatUpdate($id) {
        $criterios = Criterio::all();
        $categoria = CategoriaCriterio::find($id);
        if (!$categoria) {
            return back()->with('success', 'Categoria no encontrado');
        }
        return view('admin.cursos.criterios.edit_cat', compact('categoria', 'criterios'));
    }

    public function criteroCatAdd(Request $request) {
        try {
            $rules = [
                'criterio' => 'required|numeric',
                'nombre' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
                'porcentajeCat' => 'required|numeric|min:5|max:100',
                'totalPocentCategoria' => 'required|numeric|max:100|min:0',
            ];
            $request->validate($rules);
            CategoriaCriterio::create([
                'nombre' => $request->nombre,
                'porcentaje' => $request->porcentajeCat,
                'total' => $request->totalPocentCategoria,
                'criterio_id' => $request->criterio,
            ]);
            Criterio::find($request->criterio)->update(['total' => $request->totalPocentCategoria ]);
            return back()->with('success', 'Categoria en criterio guardado con exito');
        } catch (\Throwable $th) {
            return back()->with('error', 'Error: '. $th->getMessage());
        }
    }

    public function criteroCatUpdate(Request $request, $id) {
        try {
            $rules = [
                'criterio' => 'required|numeric',
                'nombre' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
                'porcentajeCat' => 'required|numeric|min:5|max:100',
                'totalPocentCategoria' => 'required|numeric|max:100|min:0',
            ];
            $request->validate($rules);
            $category = CategoriaCriterio::find($id);
            if ($category) {
                
                $category->nombre = $request->nombre;
                $category->porcentaje = $request->porcentajeCat;
                $category->total = $request->totalPocentCategoria;
                $category->criterio_id = $request->criterio;
                $category->save();
            }
            

            Criterio::find($request->criterio)->update(['total' => $request->totalPocentCategoria ]);
            return redirect()->route('admin.tareas.criterios')->with('success', 'Categoria en criterio guardado con exito');
        } catch (\Throwable $th) {
            return back()->with('error', 'Error: '. $th->getMessage());
        }
    }

    public function criterioCatDelete($id) {
        try {
            $crit = CategoriaCriterio::find($id);
            // Verificar si el criterio tiene relaciones con trabajos o categorías
            if ($crit->catCritTrabajos()->exists()) {
                return back()->with('error', 'No se puede borrar el criterio porque tiene relaciones con trabajos.');
            }
            // También puedes borrar la ponderación en Configuration si lo deseas
            $ponde = Criterio::find($crit->criterio_id);
            $ponde->total = $ponde->total + $crit->porcentaje;
            $ponde->save();
            // Si no tiene relaciones, se puede borrar
            $crit->delete();
            return back()->with('success', 'La categoria se borró exitosamente.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Error: '. $th->getMessage());
        }
    }

    public function selectPonderacion($id) {
        try {
            $crit = Criterio::find($id);
            if (!$crit) {
                return response()->json(['success' => false, 'message' => 'Criterio no encontrado']);
            }
            return response()->json(['success' => true, 'data' => $crit->total]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Ocurrió un error: ' . $th->getMessage()]);
        }
    }
    
}
