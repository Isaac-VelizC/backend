<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckDatabaseConnection
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            DB::connection()->getPdo();
        } catch (QueryException $e) {
            dd('fallo');
            Session::flash('database_connection_lost', '¡Conexión a la base de datos perdida!');
        }
        return $next($request);
    }
}
