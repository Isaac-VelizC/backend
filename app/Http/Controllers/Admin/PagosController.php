<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pagos;
use Illuminate\Http\Request;

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
}
