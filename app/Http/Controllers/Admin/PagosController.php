<?php

namespace App\Http\Controllers\Admin;

use App\Console\Commands\GenerarRegistrosMensuales;
use App\Http\Controllers\Controller;
use App\Models\Pagos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class PagosController extends Controller
{
    public function allPagos() {
        $pagos = Pagos::all();
        return View('admin.pagos.index', compact('pagos'));
    }
    public function guardarImprimirPago($id) {
        $pago = Pagos::find($id);
        return view('admin.pagos.pagos_factura', compact('pago'));
    }
    public function habilitarPagosMes() {
        try {
            Artisan::call('app:generar-registros-mensuales');
            $nombreMes = Carbon::now()->format('F');
            return back()->with('success', 'Pagos para el mes ' . $nombreMes . ' habilitados');
        } catch (\Exception $e) {
            // Manejar la excepción aquí
            return back()->with('error', 'Error al ejecutar el comando: ' . $e->getMessage());
        }
    }
}
