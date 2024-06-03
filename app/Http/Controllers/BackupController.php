<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;

class BackupController extends Controller
{
    public function showSettings()
    {
        // Muestra el formulario de configuración de backups
        return view('backup.settings');
    }

    public function saveSettings(Request $request)
    {
        // Guarda las configuraciones del cliente en la base de datos
        $request->validate([
            'databases' => 'required|array',
            'files' => 'required|array',
        ]);

        // Aquí podrías guardar las preferencias en la base de datos

        return redirect()->back()->with('success', 'Configuración de backup guardada correctamente.');
    }

    /*public function runBackup(Request $request)
    {
        // Ejecuta el backup basado en las configuraciones del cliente
        $backupJob = BackupJobFactory::createFromArray(config('backup'));
        
        $backupJob->dontBackupFilesystem()
                  ->dontBackupDatabases();

        // Incluye bases de datos seleccionadas
        foreach ($request->input('databases', []) as $database) {
            $backupJob->backupDatabase($database);
        }

        // Incluye archivos seleccionados
        foreach ($request->input('files', []) as $file) {
            $backupJob->backupFile($file);
        }

        $backupJob->run();

        return redirect()->back()->with('success', 'Backup ejecutado correctamente.');
    }*/

    // Método para ejecutar el backup
    public function runBackup()
    {
        try {
            Artisan::call('backup:run');
            return redirect()->back()->with('success', 'Backup ejecutado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al ejecutar el backup: ' . $e->getMessage());
        }
    }

    // Método para listar los archivos de backup
    public function listBackups()
    {
        $disk = Storage::disk('local');
        $files = $disk->files('backups');
        $backups = [];

        foreach ($files as $file) {
            $backups[] = [
                'path' => $file,
                'size' => $disk->size($file),
                'last_modified' => $disk->lastModified($file),
            ];
        }

        return view('admin.backup.list', compact('backups'));
    }

    // Método para descargar un archivo de backup
    public function downloadBackup($file)
    {
        $filePath = 'backups/' . $file;

        if (Storage::disk('local')->exists($filePath)) {
            return Storage::disk('local')->download($filePath);
        }

        return redirect()->back()->with('error', 'El archivo de backup no existe.');
    }
}
