<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    public function downloadBackup(Request $request)
    {
        // Ejecutar el comando para realizar un nuevo backup
        Artisan::call('backup:run');

        // Enviar el archivo al usuario
        return back();
    }
}
