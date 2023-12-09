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
        $formType = false;
        return view('admin.usuarios.administrador.index', compact('personals', 'formType'));
    }
    public function formInscripcion() {
        $horarios = Horario::all();
        return view('admin.usuarios.estudiantes.create', compact('horarios'));
    }
    public function inscripcion(Request $request) {
        if ($request->telefono == $request->telefonoC) {
            return back()->with('error', 'El numero de telefono ' . $request->telefono .' del estudiante es el mismo del contacto.');
        }
        $rules = [
            'nombre' => 'required|string',
            'ci' => 'required|string|unique:personas,ci|unique:personas,email|unique:personas',
            'genero' => 'required|in:Mujer,Hombre',
            'email' => 'required|email',
            'telefono' => 'nullable|string|unique:num_telefonos,numero',
            'direccion' => 'required|string',
            'fNac' => 'required|date',
            'nombreC' => 'required|string',
            'ciC' => 'required|string|unique:personas,ci',
            'generoC' => 'required|in:Mujer,Hombre',
            'emailC' => 'nullable|email',
            'telefonoC' => 'required|string|unique:num_telefonos,numero',
            'horario' => 'required|numeric',
        ];
        $request->validate($rules);
        $user = User::firstOrCreate(
            ['name' => $this->generateUniqueUsername($request->nombre)],
            ['email' => $request->email, 'password' => Hash::make('u.'.$request->ci)]
        );
        $user->assignRole('Estudiante');
        $pers = $user->persona()->create([
            'nombre' => $request->nombre,
            'ap_paterno' => $request->ap_pat,
            'ap_materno' => $request->ap_mat,
            'ci' => $request->ci,
            'genero' => $request->genero,
            'email' => $request->email,
        ]);
        $pers->numTelefono()->create(['numero' => $request->telefono]);

        $contacto = Persona::create([
            'nombre' => $request->nombreC,
            'ap_paterno' => $request->ap_patC,
            'ap_materno' => $request->ap_matC,
            'ci' => $request->ciC,
            'genero' => $request->generoC,
            'email' => $request->emailC,
            'rol' => 'F',
        ]);

        $contacto->numTelefono()->create(['numero' => $request->telefonoC]);
        $contac = $contacto->contacto()->create();

        $pers->estudiante()->create([
            'direccion' => $request->direccion,
            'fecha_nacimiento' => $request->fNac,
            'contact_id' => $contac->id,
            'turno_id' => $request->horario,
        ]);

        return redirect()->route('admin.estudinte')->with('success', 'La inscripción se ejecutó con éxito.');
    }
    private function generateUniqueUsername($nombre) {
        $username = strtolower($nombre);
        $numeroAleatorio = mt_rand(1000, 9999);
        return $username . $numeroAleatorio;
    }

    public function store(Request $request) {

        $rules = [
            'nombre' => 'required|string',
            'ap_pat' => 'nullable|string',
            'ap_mat' => 'nullable|string',
            'ci' => 'required|string|unique:personas,ci',
            'genero' => 'required|in:Mujer,Hombre',
            'email' => 'required|email|unique:personas,email',
            'telefono' => 'nullable|string',
        ];
        $request->validate($rules);
        $user = User::firstOrCreate(
            ['name' => $this->generateUniqueUsername($request->nombre)],
            ['email' => $request->email, 'password' => Hash::make('u.'.$request->ci)]
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
            'rol' => 'D'
        ]);
        $pers->numTelefono()->create([
            'numero' => $request->telefono,
        ]);
        $pers->docente()->create();
        return redirect()->route('admin.docentes')->with('success', 'La información se guardo con éxito.');
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
            $mensaje = ($accion === 'baja') ? 'Se dio de baja al docente' : 'Se dio de alta al docente';
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
        $rules = [
            'nombre' => 'required|string',
            'ap_pat' => 'nullable|string',
            'ap_mat' => 'nullable|string',
            'ci' => 'required|string|unique:personas,ci,' . $estud->persona->id,
            'genero' => 'required|in:Mujer,Hombre',
            'email' => 'required|email|unique:personas,email,' . $estud->persona->id,
            'direccion' => 'required|string',
            'telefono' => 'nullable|string',
            'fnac' => 'required|date',
            'horario' => 'required|numeric',
        ];
        $request->validate($rules);
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
        $pers->update();
        NumTelefono::where('id_persona', $pers->id)->update(['numero' => $request->telefono]);

        return back()->with('success', 'La informacion se actualizo con éxito.');
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
}
