<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    use AuthenticatesUsers, ThrottlesLogins;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, $user)
    {
        if (!$user->persona->estado ) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'cuenta inactiva');
        }
        if ($user->hasRole('Admin') || $user->hasRole('Secretario/a')) {
            return redirect()->route('admin.home');
        } elseif ($user->hasRole('Docente')) {
            return redirect()->route('docente.home');
        } elseif ($user->hasRole('Estudiante')) {
            return redirect()->route('estudiante.home');
        }
        // Si el usuario no tiene un rol específico, redirige a la página de inicio
        return redirect()->route('home');
    }

    public function username()
    {
        $login = request()->input('email');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        request()->merge([$field => $login]);
        return $field;
    }

    protected function throttleKey()
    {
        return strtolower(request()->input($this->username())) . '|' . request()->ip();
    }

    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), 2, 1 // 5 intentos en 1 minuto
        );
    }

    protected function incrementLoginAttempts(Request $request)
    {
        $this->limiter()->hit(
            $this->throttleKey($request), 40 // 60 segundos de bloqueo
        );
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey()
        );

        return response()->view('auth.throttle', ['seconds' => $seconds], 429);
        /*throw ValidationException::withMessages([
            $this->username() => [trans('auth.throttle', ['seconds' => $seconds])],
        ])->status(429);*/ // 429 Too Many Requests
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Si el usuario ha superado el número máximo de intentos de inicio de sesión, entonces dispare el evento Lockout
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // Si la tentativa de inicio de sesión ha fallado, entonces incrementa los intentos de inicio de sesión
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    
}
