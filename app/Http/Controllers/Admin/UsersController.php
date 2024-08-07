<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CursoHabilitado;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Horario;
use App\Models\NumTelefono;
use App\Models\Persona;
use App\Models\Personal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    function estudiantesAll() {
        $estudiantes = Estudiante::with('persona')->get();
        return view('admin.usuarios.estudiantes.index', compact('estudiantes'));
    }
    public function allDocentes() {
        $docentes = Persona::whereHas('docente')->get();
        $formType = true;
        return view('admin.usuarios.docente.index', compact('docentes', 'formType'));
    }
    public function allPersonal() {
        $personals = Personal::all();
        $roles = Role::whereIn('name', ['Admin', 'Secretario/a', 'Personal'])->get();
        $formType = false;
        return view('admin.usuarios.administrador.index', compact('personals', 'formType', 'roles'));
    }
    public function formInscripcion() {
        $horarios = Horario::all();
        return view('admin.usuarios.estudiantes.create', compact('horarios'));
    }
    private function generateUniqueUsername($nombre) {
        $username = strtolower($nombre);
        $numeroAleatorio = mt_rand(1000, 9999);
        return $username . $numeroAleatorio;
    }

    public function inscripcion(Request $request) {
        // Reglas de validación para el estudiante
        $rules = [
            'nombre' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'ap_pat' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'ap_mat' => 'nullable|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'ci' => 'required|string|regex:/^\d{7,8}(?:-[0-9A-Z]{1,2})?$/|unique:personas,ci|min:7',
            'genero' => 'required|in:Mujer,Hombre,Otro',
            'email' => 'required|email|unique:personas,email',
            'telefono' => 'required|string|regex:/^[0-9+()-]{8,15}$/|unique:personas,numero',
            'direccion' => 'required|string',
            'fNac' => 'required|date|before_or_equal:' . Carbon::now()->subYears(15)->format('Y-m-d'),
            'horario' => 'required|integer|exists:horarios,id',
        ];
        $request->validate($rules);
        if ($request->filled('nombreC')) {
            // Validar los datos del contacto
            $rulesContacto = [
                'nombreC' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
                'ap_patC' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
                'ap_matC' => 'nullable|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
                'ciC' => 'required|string|regex:/^\d{7,8}(?:-[0-9A-Z]{1,2})?$/|unique:personas,ci|min:7',
                'generoC' => 'required|in:Mujer,Hombre,Otro',
                'emailC' => 'nullable|email',
                'telefonoC' => 'nullable|string|regex:/^[0-9+()-]{8,15}$/|unique:personas,numero',
            ];
            $request->validate($rulesContacto);    
            if ($request->filled('telefonoC')) {
                if ($request->telefono == $request->telefonoC) {
                    return back()->with('error', 'El número de teléfono ' . $request->telefono .' del estudiante es el mismo del contacto.');
                }
            }
            $contacId = $this->saveContacto($request);
            if ($contacId === null) {
                return back()->with('error', 'Hubo un error al guardar los datos del contacto.');
            }
        }
        try {
            // Crear o recuperar el usuario
            $user = User::firstOrCreate(
                ['name' => $request->ci],// $this->generateUniqueUsername($request->ci)],
                ['email' => $request->email, 'password' => Hash::make('igla.'.$request->ci)]
            );
            $user->assignRole('Estudiante');
    
            // Crear la persona del estudiante
            $pers = $user->persona()->create([
                'nombre' => $request->nombre,
                'ap_paterno' => $request->ap_pat,
                'ap_materno' => $request->ap_mat,
                'ci' => $request->ci,
                'genero' => $request->genero,
                'email' => $request->email,
                'numero' => $request->telefono
            ]);
    
            // Crear la información del estudiante
            if ($request->filled('nombreC')) {
                $pers->estudiante()->create([
                    'direccion' => $request->direccion,
                    'fecha_nacimiento' => $request->fNac,
                    'contact_id' => $contacId,
                    'turno_id' => $request->horario,
                ]);
            } else {
                $pers->estudiante()->create([
                    'direccion' => $request->direccion,
                    'fecha_nacimiento' => $request->fNac,
                    'turno_id' => $request->horario,
                ]);
            }
    
            return redirect()->route('admin.E.show', $pers->id);
        } catch (\Throwable $th) {
            return back()->with('error', 'Hubo un error durante la inscripción. Por favor, inténtalo de nuevo. Detalles: ' . $th->getMessage());
        }
    }

    public function saveContacto(Request $request) {
        try {
            $contacto = Persona::create([
                'nombre' => $request->nombreC,
                'ap_paterno' => $request->ap_patC,
                'ap_materno' => $request->ap_matC,
                'ci' => $request->ciC,
                'genero' => $request->generoC,
                'email' => $request->emailC,
                'numero' => $request->telefonoC,
                'rol' => 'F',
            ]);
            $contac = $contacto->contacto()->create();
            return $contac->id;
        } catch (\Throwable $th) {
            return back()->with('error', 'Hubo un error en los datos del contacto. Por favor, inténtalo de nuevo. Detalles: ' . $th->getMessage());
        }
    }

    public function store(Request $request) {
        $rules = [
            'nombre' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'ap_pat' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'ap_mat' => 'nullable|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'ci' => 'required|string|regex:/^\d{7,8}(?:-[0-9A-Z]{1,2})?$/|unique:personas,ci|min:7',
            'genero' => 'required|in:Mujer,Hombre,Otro',
            'email' => 'required|email|unique:personas,email',
            'telefono' => 'nullable|string|regex:/^[0-9+()-]{8,15}$/|unique:personas,numero',
        ];
        $request->validate($rules);
        try {
            $user = User::firstOrCreate(
                ['name' => $request->ci],//$this->generateUniqueUsername($request->ci)],
                ['email' => $request->email, 'password' => Hash::make('igla.'.$request->ci)]
            );
            $user->assignRole('Docente');
            $pers = Persona::create([
                'user_id' => $user->id,
                'nombre' => $request->nombre,
                'ap_paterno' => $request->ap_pat,
                'ap_materno' => $request->ap_mat,
                'ci' => $request->ci,
                'genero' => $request->genero,
                'email' => $request->email,
                'numero' => $request->telefono,
                'rol' => 'D'
            ]);
            $pers->docente()->create();
            return redirect()->route('admin.docentes')->with('success', 'La información se guardo con éxito.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Ocurrio un error. Por favor, inténtalo de nuevo. Detalles: ' . $th->getMessage());
        }
    }

    public function gestionarEstadoEstudiante($id, $accion) {
        $persona = Persona::find($id);
        if ($persona) {
            $estado = ($accion === 'baja') ? false : true;
            $persona->update(['estado' => $estado]);
            Estudiante::where('persona_id', $id)->update(['estado' => $estado]);    
            $mensaje = ($accion === 'baja') ? 'Se dio de baja al estudiante' : 'Se dio de alta al estudiante';
            return back()->with('success', $mensaje);
        } else {
            return back()->with('error', 'No se encontró la persona');
        }
    }    
    public function gestionarEstadoDocente($id, $accion) {
        $persona = Persona::find($id);
        if ($persona) {
            $estado = ($accion === 'baja') ? false : true;
            $persona->update(['estado' => $estado]);
            Docente::where('id_persona', $id)->update(['estado' => $estado]);
            $mensaje = ($accion === 'baja') ? 'Se dio de baja al docente' : 'Se dio de alta al docente';
            return back()->with('success', $mensaje);
        } else {
            return back()->with('error', 'No se encontró la persona');
        }
    }
    public function gestionarEstadoPersonal($id, $accion) {
        $persona = Persona::find($id);
        if ($persona) {
            $estado = ($accion === 'baja') ? false : true;
            $persona->update(['estado' => $estado]);
            Personal::where('persona_id', $id)->update(['estado' => $estado]);
            $mensaje = ($accion === 'baja') ? 'Se dio de baja al personal' : 'Se dio de alta al personal';
            return back()->with('success', $mensaje);
        } else {
            return back()->with('error', 'No se encontró la persona');
        }
    }
    public function showEstudiante($id) {
        $estudiante = Persona::find($id);
        $est = Estudiante::where('persona_id', $estudiante->id)->first();
        $horarios = Horario::all();
        $materias = CursoHabilitado::all();
        return view('admin.usuarios.estudiantes.show', compact('estudiante', 'est', 'horarios', 'materias'));
    }
    public function update(Request $request, $id) {
        $estud = Estudiante::find($id);
            if ($estud) {
                $rules = [
                    'nombre' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
                    'ap_pat' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
                    'ap_mat' => 'nullable|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
                    'ci' => 'required|string|regex:/^\d{7,8}(?:-[0-9A-Z]{1,2})?$/|min:7|unique:personas,ci,' . $estud->persona->id,
                    'genero' => 'required|in:Mujer,Hombre,Otro',
                    'email' => 'required|email|unique:personas,email,' . $estud->persona->id,
                    'direccion' => 'required|string',
                    'telefono' => 'nullable|string|regex:/^[0-9+()-]{8,15}$/|unique:personas,numero,' . $estud->persona->id,
                    'fnac' => 'required|date|before_or_equal:' . Carbon::now()->subYears(15)->format('Y-m-d'),
                    'horario' => 'required|numeric|exists:horarios,id',
                ];
                $request->validate($rules);
            } else {
                return back()->with('error', 'Estudiante no encontrado');
            }
        try {
            $estud->direccion = $request->direccion;
            $estud->fecha_nacimiento = $request->fnac;
            $estud->turno_id = $request->horario;
            $estud->update();
            $pers = Persona::find($estud->persona->id);
            $pers->nombre = $request->nombre;
            $pers->ap_paterno = $request->ap_pat;
            $pers->ap_materno = $request->ap_mat;
            $pers->ci = $request->ci;
            $pers->genero = $request->genero;
            $pers->email = $request->email;
            $pers->numero = $request->telefono;
            $pers->update();

            User::find($pers->user_id)->update([
                'name' => $request->ci,
                'email' => $request->email,
                'password' => Hash::make('igla.'.$request->ci)
            ]);
    
            return back()->with('success', 'La informacion se actualizo con éxito.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Ocurrio un error: '.$th->getMessage());
        }
    }
    public function selectEstudiante(Request $request) {
        $query = $request->input('name');

        $estudiantes = Estudiante::where(function ($queryBuilder) use ($query) {
            $queryBuilder->whereHas('persona', function ($q) use ($query) {
                $q->where('nombre', 'like', "%$query%")
                ->orWhere('ap_paterno', 'like', "%$query%")
                ->orWhere('ap_materno', 'like', "%$query%")
                ->orWhere('ci', 'like', "%$query%");
            });
        })->with('persona')->get();

        return response()->json($estudiantes);
    }  
    
    public function quitarRole($id) {
        // Obtener el usuario
        $user = User::find($id);
        // Quitar el rol 'Docente' del usuario
        $user->removeRole('Docente');
        return back()->with('success', 'Se quito el rol con exito');
    }
}
