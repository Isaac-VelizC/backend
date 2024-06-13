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
    public static function nombres() {
        $mes = (new DateTime())->format('F');

        switch ($mes) {
            case 'January':
                return 'Enero';
            case 'February':
                return 'Febrero';
            case 'March':
                return 'Marzo';
            case 'April':
                return 'Abril';
            case 'May':
                return 'Mayo';
            case 'June':
                return 'Junio';
            case 'July':
                return 'Julio';
            case 'August':
                return 'Agosto';
            case 'September':
                return 'Septiembre';
            case 'October':
                return 'Octubre';
            case 'November':
                return 'Noviembre';
            case 'December':
                return 'Diciembre';
            default:
                return 'No existe el mes'; // Manejar el caso en el que el nombre del mes no esté definido
        }
    }

    public function allPagos() {
        $mesActual = $this->nombres();
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

    public function storeImprimirPago(Request $request) {
        return 0;
    }

    public function formPagos() {
        $formaPagos = FormaPago::all();
        $metodo = MetodoPago::all();
        $fecha = now()->toDateString();
        $isEditing = false;
        return view('admin.pagos.form_pago', compact('isEditing', 'formaPagos', 'fecha', 'metodo'));
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
    }

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
    
    public function historialPago() {
        // Obtener el mes y año actual
        $month = date('m');
        $year = date('Y');
        $nombreMes = $this->nombres(); 
        // Obtener los pagos realizados en el mes actual
        $pagosMesActual = PagoMensual::whereMonth('fecha', $month)->whereYear('fecha', $year)->get();
        // Calcular la suma total del monto total de todos los pagos
        $totalMonto = $pagosMesActual->sum('monto');
        $pagosPorMetodo = $pagosMesActual->groupBy('metodo_id')->map(function ($pagos) {
            // Obtener el primer pago para acceder a la relación
            $primerPago = $pagos->first();
            // Obtener el nombre del método de pago
            $nombreMetodo = $primerPago->metodoPago->nombre;
            return [
                'tipo' => $nombreMetodo,
                'cantidad' => $pagos->count(),
                'monto_total' => $pagos->sum('monto'),
            ];
        });
        // Obtener la lista de estudiantes que no han pagado en ningún mes
        $estudiantesSinPago = $this->estudiantesDebenPagar();
        // Pasar los datos a la vista
        return view('admin.pagos.historial', compact('pagosPorMetodo', 'estudiantesSinPago', 'totalMonto', 'nombreMes'));
    }

    public function estudiantesDebenPagar() {
        // Obtener el mes y año actual
        $mesActual = date('m');
        $añoActual = date('Y');
        // Obtener todos los métodos de pago disponibles
        $metodosPago = MetodoPago::all();
        // Inicializar un arreglo para almacenar los resultados
        $resultados = [];
        foreach ($metodosPago as $metodoPago) {
            // Obtener los estudiantes que no han realizado ningún pago mensual con este método de pago para el mes actual
            $estudiantesSinPago = Estudiante::whereDoesntHave('pagosMensuales', function ($query) use ($metodoPago, $mesActual, $añoActual) {
                $query->where('metodo_id', $metodoPago->id)
                    ->where('mes', $mesActual)
                    ->where('anio', $añoActual);
            })->get();

            // Si hay estudiantes que no han pagado con este método de pago, agregarlos a los resultados
            if ($estudiantesSinPago->isNotEmpty()) {
                $estudiantes = $estudiantesSinPago->map(function ($estudiante) {
                    return $estudiante->persona->nombre .' '. $estudiante->persona->ap_paterno .' '. $estudiante->persona->ap_materno;
                });

                $resultados[] = [
                    'metodo_pago' => $metodoPago->nombre,
                    'estudiantes' => $estudiantes->toArray(),
                    'cantidad' => $metodoPago->monto, 
                ];
            }
        }
        return $resultados;
    }
    public function editPage($id) {
        $formaPagos = FormaPago::all();
        $metodo = MetodoPago::all();
        $pago = Pagos::findorfail($id);
        $pagoMensual = PagoMensual::where('pago_id', $id)->get();
        $fecha = now()->toDateString();
        $est = Estudiante::find($pago->est_id);
        $estudiante = $est->persona->nombre .' '. $est->persona->ap_paterno .' '. $est->persona->ap_materno . '- CI: '. $est->persona->ci;
        $isEditing = true;
        return view('admin.pagos.form_pago', compact('isEditing', 'formaPagos', 'fecha', 'metodo', 'pago', 'pagoMensual', 'estudiante'));
    }

    public function updatePago(Request $request, $id) {
        $rules = [
            'forma' => 'required|numeric|exists:formas_pagos,id',
            'estudiante' => 'numeric|exists:estudiantes,id',
            'monto' => 'required|array',
            'monto.*' => 'exists:metodo_pagos,id',
            'descripcion' => 'nullable|string',
        ];
        $request->validate($rules);
        try {
            // Sumar los montos de los métodos de pago seleccionados
            $total = 0;
            $fechaActual = Carbon::now();
            foreach ($request->monto as $montoId) {
                $metodoPago = MetodoPago::find($montoId);
                if (!$metodoPago) {
                    return back()->with('error', 'No existe el monto de pago.');
                }
                $total += $metodoPago->monto;
            }
            
            $pago = Pagos::find($id);
            if ($request->filled('estudiante')) {
                $pago->est_id = $request->estudiante;
            }
            $pago->forma_id = $request->forma;
            $pago->monto = $total;
            $pago->comentario = $request->descripcion;
            $pago->update();
            // Crear los pagos mensuales
            foreach ($request->monto as $montoId) {
                // Obtener el monto del método de pago
                $metodoPago = MetodoPago::find($montoId);
                if (!$metodoPago) {
                    return back()->with('error', 'No existe el monto de pago.');
                }
                $pagoExistente = PagoMensual::where('pago_id', $id)
                                ->where('metodo_id', $montoId)
                                ->exists();
                if (!$pagoExistente) {
                    $mes = date('m', strtotime($fechaActual));
                    $anio = date('Y', strtotime($fechaActual));
                    // Generar el código mensual
                    $codeMensual = $this->generarCode($fechaActual, 'mensual');
                    // Crear el pago mensual
                    PagoMensual::create([
                        'estudiante_id' => $pago->est_id,
                        'metodo_id' => $montoId,
                        'pago_id' => $pago->id,
                        'mes' => $mes,
                        'anio' => $anio,
                        'fecha' => $fechaActual,
                        'pagado' => true,
                        'codigo' => $codeMensual,
                        'monto' => $metodoPago->monto
                    ]);
                }
            }
            // Enviar notificación al estudiante si tiene un número de teléfono registrado
            $estudiante = Estudiante::find($pago->est_id);
            $numeroTelefono = optional($estudiante->persona)->numero;
            if ($numeroTelefono) {
                $message = 'Su pago de '. $total .'bs. fue registrado con éxito, querido estudiante: '. optional($estudiante->persona)->nombre;
                InfoController::notificacionNotaTarea($numeroTelefono, $message);
            }
            return redirect()->route('admin.lista.pagos')->with('success', 'Se registró su pago exitosamente. Monto total: '.$total);
        } catch (\Throwable $th) {
            return back()->with('error', 'Ocurrió un error: ' . $th->getMessage());
        }
    }

}
