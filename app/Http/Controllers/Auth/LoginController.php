<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login($user)
    {
        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.home');
        } elseif ($user->hasRole('Chef')) {
            return redirect()->route('chef.home');
        } elseif ($user->hasRole('Estudiante')) {
            return redirect()->route('estudiante.home');
        }
        return redirect()->route('/');
    }
}
