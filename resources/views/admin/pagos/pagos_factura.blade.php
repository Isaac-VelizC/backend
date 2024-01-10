@extends('layouts.app')
@section('content')
    <div class="iq-navbar-header" style="height: 80px;"></div>
    <div class="conatiner-fluid content-inner mt-n5 py-0">
       <div class="row">
          <div class="col-sm-12">
             <div class="card">
                <div class="card-body">
                    <table class="printer-ticket">
                        <thead>
                           <tr>
                               <th class="title" colspan="3">INSTITUTO TECTICO IGLA</th>
                           </tr>
                           <tr>
                               <th colspan="3">{{ $pago->fecha }}</th>
                           </tr>
                           <tr>
                               <th colspan="3">
                                Nombre Cliente: {{ $pago->estudiante->persona->nombre }} {{ $pago->estudiante->persona->ap_paterno }} {{ $pago->estudiante->persona->ap_materno }}<br />
                                NIT: {{ $pago->estudiante->persona->ci }}
                               </th>
                           </tr>
                       </thead>
                       <tbody>
                           <tr class="top">
                               <td colspan="3">{{ $pago->comentario }}</td>
                           </tr>
                           <tr class="ttu">
                               <td colspan="2">Monto</td>
                               <td align="right">{{ $pago->monto }}bs.</td>
                           </tr>
                       </tbody>
                       <tfoot>
                           <tr class="sup ttu p--0">
                               <td colspan="3">
                                   <b>Total</b>
                               </td>
                           </tr>
                           <tr class="ttu">
                               <td colspan="2">Sub-total</td>
                               <td align="right">{{ $pago->monto }}bs.</td>
                           </tr>
                           <tr class="sup">
                               <td colspan="3" align="center">
                                   <b>Pedido:</b>
                               </td>
                           </tr>
                           <tr class="sup">
                               <td colspan="3" align="center">
                                   www.site.com
                               </td>
                           </tr>
                       </tfoot>
                    </table>
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary">Imprimir</button>
                    </div>
                </div>
             </div>
          </div>
       </div>
   </div>
@endsection