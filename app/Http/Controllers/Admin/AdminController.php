<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Evento;
use App\Models\Inventario;
use App\Models\Materia;
use App\Models\Persona;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function allUsers() {
        $users = Persona::join('users', 'personas.user_id', '=', 'users.id')
            ->where('users.id', '<>', 1) // Excluir usuario con ID 1
            ->select('personas.*')
            ->get();
        return view('admin.usuarios.lista_users', compact('users'));
    }   
    public function index() {
        
        $mes = PagosController::nombres();
        $users = User::all()->count();
        $estudiantes = Estudiante::all()->count();
        $docentes = Docente::all()->count();
        $materias = Materia::all()->count();
        $eventos = Evento::where('estado', 1)->get();
        $countInventario = Inventario::all()->count();
        return view('admin.home', compact('users', 'estudiantes', 'docentes', 'materias', 'eventos', 'mes', 'countInventario'));
    }
    public function store(Request $request) {
        $rules = [
            'nombre' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'ap_pat' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'ap_mat' => 'nullable|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'ci' => 'required|string|regex:/^\d{7,9}(?:-[0-9A-Z]{1,2})?$/|unique:personas,ci|min:7',
            'genero' => 'required|in:Mujer,Hombre,Otro',
            'email' => 'required|email|unique:personas,email',
            'telefono' => 'nullable|string|regex:/^[0-9+()-]{8,15}$/|unique:personas,numero',
            'rol' => 'required|numeric|exists:roles,id',
            'cargo' => 'nullable|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u'
        ];
        $request->validate($rules);
        try {
            $user = null;
            if ($request->acesso === 'S') {
                $user = User::firstOrCreate(
                    ['name' => $request->ci ], //$this->generateUniqueUsername($request->nombre)],
                    ['email' => $request->email, 'password' => Hash::make('igla.'.$request->ci)]
                );
                $role = Role::findById($request->rol);
                if ($role) {
                    $user->assignRole($role);
                } else {
                    return back()->with('error', 'El rol seleccionado no existe.');
                }
            }
            
            $pers = Persona::create([
                'user_id' => optional($user)->id,
                'nombre' => $request->nombre,
                'ap_paterno' => $request->ap_pat,
                'ap_materno' => $request->ap_mat,
                'ci' => $request->ci,
                'genero' => $request->genero,
                'email' => $request->email,
                'numero' => $request->telefono,
                'rol' => 'P'
            ]);
            $pers->personal()->create([
                'persona_id' => $pers->id,
                'f_contrato' => Carbon::now(),
                'cargo' => $request->cargo,                
            ]);
            return redirect()->route('admin.personal')->with('success', 'La información se guardo con éxito.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Ocurrio un error. Por favor, inténtalo de nuevo. Detalles: ' . $th->getMessage());
        }
    }
    private function generateUniqueUsername($nombre) {
        $username = strtolower($nombre);
        $numeroAleatorio = mt_rand(1000, 9999);
        return $username . $numeroAleatorio;
    }
}