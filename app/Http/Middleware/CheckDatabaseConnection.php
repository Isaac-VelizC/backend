<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use PDOException;
use Symfony\Component\HttpFoundation\Response;

class CheckDatabaseConnection
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            DB::connection()->getPdo();
        } catch (PDOException $e) {
            Log::error('Error de conexión a la base de datos: ' . $e->getMessage());
            // Redirige a una página de error o muestra un mensaje al usuario
            Session::flash('database_connection_lost', '¡Conexión a la base de datos perdida!');
            // Puedes redirigir a una página de error específica
            return redirect('/');
        }
        return $next($request);
    }
}
