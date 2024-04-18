<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\InfoController;
use App\Models\Estudiante;
use App\Models\FormaPago;
use App\Models\MetodoPago;
use App\Models\PagoMensual;
use App\Models\Pagos;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
setlocale(LC_TIME, 'es_ES'); // Establecer la configuración regional en español

class PagosController extends Controller
{
    public function allPagos() {
        $mesActual = (new DateTime())->format('F'); // Obtener el nombre completo del mes actual en inglés
        // Traducir el nombre del mes al español
        $meses = [
            'January' => 'Enero',
            'February' => 'Febrero',
            'March' => 'Marzo',
            'April' => 'Abril',
            'May' => 'Mayo',
            'June' => 'Junio',
            'July' => 'Julio',
            'August' => 'Agosto',
            'September' => 'Septiembre',
            'October' => 'Octubre',
            'November' => 'Noviembre',
            'December' => 'Diciembre',
        ];

        $mesActual = $meses[$mesActual]; 
        $estudiantes = Estudiante::where('estado', 1)->count();
        $pagos = Pagos::all();
        return View('admin.pagos.index', compact('pagos', 'estudiantes', 'mesActual'));
    }
    public function guardarImprimirPago($id) {
        $pago = Pagos::find($id);
        $datos = PagoMensual::where('pago_id', $id)->get();
        return view('admin.pagos.pagos_factura', compact('pago', 'datos'));
    }
    public function habilitarPagosMes() {
        try {
            Artisan::call('app:generar-registros-mensuales');
            $nombreMes = Carbon::now()->format('F');
            return back()->with('success', 'Pagos para el mes ' . $nombreMes . ' habilitados');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al ejecutar el comando: ' . $e->getMessage());
        }
    }
    public function formPagos() {
        $formaPagos = FormaPago::all();
        $metodo = MetodoPago::all();
        $fecha = now()->toDateString();
        return view('admin.pagos.form_pago', compact('formaPagos', 'fecha', 'metodo'));
    }

    public function storePagosSimples(Request $request) {
        $rules = [
            'forma' => 'required|numeric|exists:formas_pagos,id',
            'estudiante' => 'required|numeric|exists:estudiantes,id',
            'fecha' => 'required|date',
            'monto' => 'required|array',
            'monto.*' => 'exists:metodo_pagos,id',
            'descripcion' => 'nullable|string',
        ];
        $request->validate($rules);
        try {
            // Sumar los montos de los métodos de pago seleccionados
            $total = 0;
            foreach ($request->monto as $montoId) {
                $metodoPago = MetodoPago::find($montoId);
                if (!$metodoPago) {
                    return back()->with('error', 'No existe el monto de pago.');
                }
                $total += $metodoPago->monto;
            }
            // Generar el código para el pago
            $code = $this->generarCode($request->fecha, 'pago');
            // Crear el pago
            $pago = Pagos::create([
                'responsable_id' => auth()->user()->id,
                'est_id' => $request->estudiante,
                'forma_id' => $request->forma,
                'fecha' => $request->fecha,
                'monto' => $total,
                'comentario' => $request->descripcion,
                'codigo' => $code,
            ]);
            // Crear los pagos mensuales
            foreach ($request->monto as $montoId) {
                // Obtener el monto del método de pago
                $metodoPago = MetodoPago::find($montoId);
                if (!$metodoPago) {
                    return back()->with('error', 'No existe el monto de pago.');
                }
                // Extraer mes y año de la fecha
                $mes = date('m', strtotime($request->fecha));
                $anio = date('Y', strtotime($request->fecha));
                // Generar el código mensual
                $codeMensual = $this->generarCode($request->fecha, 'mensual');
                // Crear el pago mensual
                PagoMensual::create([
                    'estudiante_id' => $request->estudiante,
                    'metodo_id' => $montoId,
                    'pago_id' => $pago->id,
                    'mes' => $mes,
                    'anio' => $anio,
                    'fecha' => $request->fecha,
                    'pagado' => true,
                    'codigo' => $codeMensual,
                    'monto' => $metodoPago->monto
                ]);
            }
            // Enviar notificación al estudiante si tiene un número de teléfono registrado
            $estudiante = Estudiante::find($request->estudiante);
            $numeroTelefono = optional($estudiante->persona)->numero;
            if ($numeroTelefono) {
                $message = 'Su pago de '. $total .'bs. fue registrado con éxito, querido estudiante: '. optional($estudiante->persona)->nombre;
                InfoController::notificacionNotaTarea($numeroTelefono, $message);
            }
            return redirect()->route('admin.lista.pagos')->with('success', 'Se registró su pago exitosamente: Código de pago: '.$code.'. Monto total: '.$total);
        } catch (\Throwable $th) {
            return back()->with('error', 'Ocurrió un error: ' . $th->getMessage());
        }
    }

    private function generarCode($fecha, $tipo) {
        // Formatear la fecha en el formato deseado
        $fechaFormateada = date('md', strtotime($fecha));
        // Obtener el siguiente número de secuencia para el tipo dado
        $ultimoCodigo = '';
        if ($tipo == 'pago') {
            $ultimoCodigo = Pagos::max('codigo');
        } else {
            $ultimoCodigo = PagoMensual::max('codigo');
        }
        $numeroSecuencia = $ultimoCodigo ? (int)substr($ultimoCodigo, -4) + 1 : 1;
        // Construir el código completo
        $codigo = 'IGLA'. '-' . $fechaFormateada . '-' . str_pad($numeroSecuencia, 4, '0', STR_PAD_LEFT);
        
        return $codigo;
    }// Establecer la configuración regional en español

    public function obtenerDetallesPago($id) {
        $data = Pagos::findOrFail($id);
        $fechaCompleta = $data->fecha;
        // Convertir la fecha a un objeto DateTime
        $fechaObj = new DateTime($fechaCompleta);
        // Formatear la fecha en español
        $fecha = $fechaObj->format('d \d\e F \d\e Y');
        // Obtener la hora
        $hora = $fechaObj->format('H:i:s');
        $pago = [
            'estudiante' => $data->estudiante->persona->nombre .' '. $data->estudiante->persona->ap_paterno  .' '. $data->estudiante->persona->ap_materno,
            'nit' => $data->estudiante->persona->ci,
            'fecha' => $fecha,
            'hora' => $hora,
            'tipo' => $data->formaPago->nombre,
        ];    
        $datos = PagoMensual::where('pago_id', $id)->get();
        $mesuales = [];
        foreach ($datos as $value) {
            $mesuales[] = [
                'codigo' => $value->codigo,
                'descripcion' => $value->metodoPago->nombre ?? null,
                'monto' => $value->monto,
                'subtotal' => $value->monto, // ¿Este es el subtotal?
            ];
        }
        // Devolver los datos en formato JSON
        return response()->json(['pago' => $pago, 'mesuales' => $mesuales]);
    }
    
}
