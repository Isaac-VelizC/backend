<?php

namespace App\Http\Controllers;

use App\Models\CodePassword;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function pageCambiarContraseña()
    {
        return view('auth.change.reset');
    }

    public function enviarCodigo(Request $request) {
        $validator = Validator::make($request->all(), [
            'numero' => 'required|string|regex:/^[0-9+()-]{8,15}$/',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $persona = Persona::where('numero', $request->numero)->first();

        if (!$persona) {
            return back()->with('error', 'No se encontró el número.');
        }

        // Generar código único de 8 dígitos
        $code = mt_rand(10000000, 99999999);

        CodePassword::create([
            'code' => $code,
            'user' => $persona->user->id,
        ]);
        // Construir el mensaje con el código
        $message = "El código para recuperar su contraseña es " . $code;

        InfoController::notificacionNotaTarea($persona->numero, $message);

        return redirect()->route('verify.code');
    }

    
    public function verificarCodigo()
    {
        return view('auth.change.verif_code');
    }

    public function verificarCodigoPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'code' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $codePassword = CodePassword::where('code', $request->code)->first();

        if (!$codePassword) {
            return back()->with('error', 'El código proporcionado no existe.');
        }

        $user = $codePassword->user;

        return redirect()->route('verify.code.pass.page', $user);
    }

    public function pagePassword($user) {
        return view('auth.change.change', compact('user'));
    }

    public function actualizarPassword(Request $request) {
        // Validaciones
        $request->validate([
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password',
            'user_id' => 'required|exists:users,id',
        ]);

        // Actualizar la contraseña del usuario
        User::find($request->user_id)->update([
            'password' => Hash::make($request->password),
        ]);

        // Redireccionar al formulario de login con un mensaje de éxito
        return redirect()->route('login');
    }
}
