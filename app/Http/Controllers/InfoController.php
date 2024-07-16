<?php

namespace App\Http\Controllers;

use App\Imports\EstudiantesImport;
use App\Models\CursoHabilitado;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Twilio\Rest\Client;

class InfoController extends Controller
{
    public function notificacionsPage() {
        return view('admin.notification.index');
    }

    public static function notificacionTrabajoPublicado($id, $message)
    {
        $curso = CursoHabilitado::with('inscripciones.estudiante')->find($id);
        $estudiantes = $curso->inscripciones->pluck('estudiante');

        $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));
        try {
            foreach ($estudiantes as $estudiante) {
                $recipientNumber = 'whatsapp:+59169625120';// . $estudiante->persona->numTelefono->numero;
                $twilio->messages->create(
                    $recipientNumber,
                    [
                        "from" => "whatsapp:+14155238886",
                        "body" => $message,
                    ]
                );
            }
            return response()->json(['message' => 'Se le notificó a los estudiantes']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public static function notificacionNotaTarea($num, $message) {
        $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));
        try {
            $recipientNumber = 'whatsapp:+59169625120';// . $num;
            $twilio->messages->create(
                $recipientNumber,
                [
                    "from" => "whatsapp:+14155238886",
                    "body" => $message,
                ]
            );
            return response()->json(['message' => 'Se le notificó a los estudiantes']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function generateAIReceta() {
        return view('generate_ai');
    }

    public function termOfUse() {
        return view('layouts.footer.termUse');
    }

    public function privacPolitics() {
        return view('layouts.footer.privacyPolitics');
    }

    public function importDatos(Request $request) {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        try {
            $file = $request->file('file');
            Excel::import(new EstudiantesImport, $file);
            return back()->with('success', 'Datos importados exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error inesperado durante la importación.');
        }
    }
}
