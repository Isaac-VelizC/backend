<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class InactivityMiddleware
{
    /*public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }*/
    public function handle($request, Closure $next, $minutes = 20)
    {
        if (Auth::check()) {
            $lastActivity = session('last_activity_time');
            $currentTime = Carbon::now();
            Log::info('Inactivity middleware running for user: ' . Auth::user()->id);

            if ($lastActivity && $currentTime->diffInMinutes($lastActivity) >= $minutes) {
                Log::info('User logged out due to inactivity: ' . Auth::user()->id);
                Auth::logout();
                session()->forget('last_activity_time'); // Limpiar la sesión de la última actividad
                return redirect('/login')->with('message', 'Your session has expired due to inactivity.');
            }

            session(['last_activity_time' => $currentTime]);
        }

        return $next($request);
    }
}
