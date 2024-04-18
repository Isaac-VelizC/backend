<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.home');
        } elseif ($user->hasRole('Docente')) {
            return redirect()->route('docente.home');
        } elseif ($user->hasRole('Estudiante')) {
            return redirect()->route('estudiante.home');
        }
        // Si el usuario no tiene un rol específico, redirige a la página de inicio
        return redirect()->route('home');
    }

    /*public function username()
    {
        $login = request()->input('username_or_email');

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        request()->merge([$field => $login]);

        return $field;
    }*/
    
}
