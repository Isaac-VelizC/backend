<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistorialInventario;
use App\Models\Ingrediente;
use App\Models\Inventario;
use App\Models\Receta;
use App\Models\RecetaGenerada;
use App\Models\TipoIngrediente;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class CocinaController extends Controller
{
    public function allIngredientes() {
        $recetas = Receta::all();
        $types = TipoIngrediente::all();
        return view('admin.recetas.ingredientes.index', compact('recetas', 'types'));
    }
    public function allrecetas() {
        $recetas = [];
        return view('admin.recetas.index', compact('recetas'));
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
                'nombre' => 'required|string|max:255|unique:ingredientes,nombre|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
                'tipo' => 'required|numeric|exists:tipo_ingrediente,id',
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
    public function generarReceta(Request $request) {
        $this->validate($request, [
            'tipoPlato' => 'required|string|max:255',
            'tags*' => 'required|numeric',
        ]);

        try {
            // Ruta al script Python
            $scriptPath = 'D:/borrar/python/flor.py';//base_path('public/python/suma.py');
            $ingredientesIds = $request->input('tags');
            // Consultar la base de datos para obtener los nombres de los ingredientes
            $ingredientesNombres = Ingrediente::whereIn('id', $ingredientesIds)->pluck('nombre')->toArray();
            $data = [
                'tipoPlato' => $request->tipoPlato,
                'tags' => $ingredientesNombres,
            ];
            // Construir el comando con parámetros
            $ingredientesJson = str_replace('"', '\"', json_encode($ingredientesNombres)); // Escapar comillas

            // Activate virtual environment
            $virtualEnvPath = 'D:/borrar/python/venv';
            $activateScript = $virtualEnvPath . '/Scripts/activate';
            shell_exec("$activateScript");

            $command = sprintf('python "%s" "%s" "%s"', $scriptPath, $ingredientesJson, $request->tipoPlato);
            $output = shell_exec($command);
            dd($output);
            return back()->with('success', 'Recetas generadas correctamente ' . $output, compact('output'));
        } catch (\Throwable $th) {
            return back()->with('error', 'Error al generar: ' . $th->getMessage());
        }
    }

    public function generarRecetaOpenAI(Request $request) {
        try {
            $this->validate($request, [
                'tipoPlato' => 'required|string|max:255',
                'tiempo' => 'required|numeric|min:10',
                'porcion' => 'required|numeric|min:1',
                'tags.*' => 'required|numeric',
            ]);
            // Obtener los nombres de los ingredientes
            $tags = $request->tags;
            $ingredientes = Ingrediente::whereIn('id', $tags)->pluck('nombre')->toArray();
            // Construir la pregunta para OpenAI
            $question = "¿podrías proporcionarme una receta para un/a " . $request->tipoPlato . " que utilice " . implode(', ', $ingredientes) . " como ingredientes para un tiempo de " . $request->tiempo .", y una cantida de " . $request->porcion . " pociones ? 
            Sería genial si pudieras incluir los pasos de preparación. Además, ¿podrías organizar la receta en una estructura HTML dentro de un div con las clases
             de container? Sería ideal que el título esté en un h1 con el id 'titulo', los ingredientes en una etiqueta <ul> con el id
            'ingredientes', y cada ingrediente tenga su id único que se incremente. Los pasos de preparación deberían estar en una etiqueta <ol> con un id 'pasos' con 
            cada paso teniendo su id único que también se incremente. Por último, 
            ¿podrías añadir el tiempo estimado de preparación y la cantidad de porciones, cada uno con su id correspondiente? y no incluir la cabezera de la estructura html ¡Gracias!";
            // Enviar la consulta a OpenAI
            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo-0301',
                'messages' => [
                    ['role' => 'user', 'content' => $question],
                ],
            ]);
            // Procesar la respuesta
            $answer = trim($response['choices'][0]['message']['content']);
            $recetas = $answer;
            //$recetas = $this->procesarRespuestaOpenAI($answer);
            // Devolver la respuesta a la vista
            return view('admin.recetas.index', ['question' => $question, 'recetas' => $recetas]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Manejar errores de validación de la solicitud
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Manejar otros errores inesperados
            return back()->with('error', 'Error al generar: ' . $e->getMessage());
        }
    }

    private function procesarRespuestaOpenAI($answer) {
        $recetas = [];
        $lines = explode("\n", $answer);
    
        $currentReceta = null;
        foreach ($lines as $line) {
            $line = trim($line);
    
            if (empty($line)) {
                continue;
            }
    
            // Si la línea comienza con un número, es un paso de receta
            if (preg_match('/^\d+\./', $line)) {
                if ($currentReceta) {
                    $currentReceta['pasos'][] = $line;
                }
            } else {
                // Si no, es parte del título, ingredientes, etc.
                if ($currentReceta) {
                    $recetas[] = $currentReceta;
                }
                $currentReceta = $this->procesarLineaReceta($line);
            }
        }
    
        // Agregar la última receta si existe
        if ($currentReceta) {
            $recetas[] = $currentReceta;
        }
    
        return $recetas;
    }
    
    private function procesarLineaReceta($line) {
        return [
            'titulo' => $line,
            'ingredientes' => [],
            'pasos' => [],
        ];
    }
    
    public function inventarioIndex() {
        $ingredientes = Inventario::all();
        return view('admin.inventario.index', compact('ingredientes'));
    }
    public function createForm() {
        $types = TipoIngrediente::all();
        $isEditing = false;
        return view('admin.inventario.create', compact('types', 'isEditing'));
    }
    public function editForm($id) {
        $types = TipoIngrediente::all();
        $invetario = Inventario::find($id);
        $isEditing = true;
        return view('admin.inventario.create', compact('types', 'invetario', 'isEditing'));
    }
    public function guardarInventario(Request $request) {
        $this->validate($request, [
            'ingredientes' => 'required|numeric|exists:ingredientes,id',
            'cantidad' => 'required|numeric|min:1',
            'unidad' => 'required|string',
        ]);
        try {
            Inventario::create([
                'ingrediente_id' => $request->ingredientes,
                'cantidad' => $request->cantidad,
                'unidad_media' => $request->unidad,
                'fecha_modificacion' => Carbon::now()
            ]);
            return redirect()->route('admin.gestion.inventario')->with('success', 'Se registro correctamente');
        } catch (\Throwable $th) {
            return back()->with('error', 'Ocurrio un error: ' . $th->getMessage());
        }
    }
    public function updateInventario(Request $request, $id) {
        $this->validate($request, [
            'ingredientes' => 'numeric|exists:ingredientes,id',
            'cantidad' => 'required|numeric|min:1',
            'unidad' => 'required|string',
        ]);
        try {
            Inventario::find($id)->update([
                'ingrediente_id' => $request->ingredientes ?? $request->default,
                'cantidad' => $request->cantidad,
                'unidad_media' => $request->unidad,
                'fecha_modificacion' => Carbon::now()
            ]);
            return redirect()->route('admin.gestion.inventario')->with('success', 'Se actualizo correctamente');
        } catch (\Throwable $th) {
            return back()->with('error', 'Ocurrio un error: ' . $th->getMessage());
        }
    }
    public function darBajaInvetario($id) {
        try {
            $item = Inventario::find($id);
            if ($item->estado == 'No disponible') {
                $item->estado = 'Disponible';
            } else if ($item->estado == 'Disponible') {
                $item->estado = 'No disponible';
            }
            $item->update();
            return back()->with('success', 'Se aplico con exito');
        } catch (\Throwable $th) {
            return back()->with('error', 'Ocurrio un error: ' . $th->getMessage());
        }
    }
    public function eliminarInvetario($id) {
        try {
            Inventario::find($id)->delete();
            return back()->with('success', 'El inventario se elimino');
        } catch (\Throwable $th) {
            return back()->with('error', 'Ocurrio un error: ' . $th->getMessage());
        }
    }
    public function updateCantidad(Request $request, $id) {
        $this->validate($request, [
            'cantidad' => 'required|numeric|min:1',
        ]);
        try {
            $item = Inventario::find($id);
            $item->cantidad = $item->cantidad + $request->cantidad;
            $item->save();
            $mensage = 'Se agrego una cantidad de '. $request->cantidad .' sobre ' . $item->ingrediente->nombre;
            HistorialInventario::create([
                'cantidad' => $request->cantidad,
                'user_id' => auth()->user()->id,
                'inventario_id' => $item->id,
                'descripcion' => $mensage,
                'fecha' => Carbon::now(),
                'estado' => 0
            ]);
            return back()->with('success', 'Se Agrego correctamente');
        } catch (\Throwable $th) {
            return back()->with('error', 'Ocurrio un error: ' . $th->getMessage());
        }
    }

    public function guardarRecetaOpenAI(Request $request) {
        try {
            // Extraer el tiempo en minutos
            $tiempo = preg_replace('/[^0-9]/', '', $request->tiempo); // Eliminar todo excepto los números
            $tiempoMinutos = intval($tiempo); // Convertir a entero
            // Guardar los datos de la receta en la base de datos
            $receta = new RecetaGenerada();
            $receta->titulo = $request->titulo;
            $receta->ingredientes = json_encode($request->ingredientes);
            $receta->pasos = json_encode($request->pasos);
            $receta->tiempo = $tiempoMinutos;
            $receta->porciones = $request->porciones;
            $receta->descripcion = 'Receta generada';
            $receta->fecha = now();
            $receta->save();
            return response()->json(['success' => 'Receta guardada exitosamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error: ' . $e->getMessage()], 500);
        }
    }
}
