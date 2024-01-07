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

        // Ruta al último archivo de copia de seguridad generado
        $backupPath = storage_path('app/backups/') . Artisan::output();

        // Enviar el archivo al usuario
        return response()->download($backupPath);
    }
}
