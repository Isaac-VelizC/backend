<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    public function downloadBackup(Request $request)
    {
        // Obtener la URL para ejecutar una copia de seguridad a través de phpMyAdmin
        $phpMyAdminBackupUrl = config('database.connections.mysql.host') . '/phpmyadmin/db_structure.php?db=' . config('database.connections.mysql.database') . '&token=' . csrf_token() . '&ajax_request=true&db_select=' . config('database.connections.mysql.database') . '&db_structure.php?server=' . config('database.connections.mysql.host');

        // Redirigir a la URL de copia de seguridad en phpMyAdmin
        return redirect($phpMyAdminBackupUrl);
    }

}
