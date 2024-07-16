<div>
   <div class="col-sm-12">
      @if(session('success'))
      <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
         <span>{{ session('success') }}</span>
         <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      @if(session('error'))
      <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
         <span>{{ session('error') }}</span>
         <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      <div class="card">
         <div class="card-body p-0">
            <div class="text-center py-2">
               <a class="btn btn-sm btn-warning" href="{{ route("admin.create.pago") }}">Registrar Pagos</a>
            </div>
            <div class="table-responsive pricing pt-2">
               <table class="table table-bordered mb-0">
                  <tbody>
                     <tr>
                        <th colspan="5" class="bg-light">Fecha Pago</th>
                     </tr>
                     @if (count($pagos) > 0)
                     @foreach ($pagos as $pago)
                     <tr>
                        <th scope="row">
                           <i class="bi bi-check"></i>
                           {{ \Carbon\Carbon::parse($pago->fecha)->locale('es_ES')->isoFormat('LL') }}
                        </th>
                        <td class="text-center">
                           @if ($pago->pagoMensual)
                           <p>{{ \Carbon\Carbon::create()->month($pago->pagoMensual->mes)->locale('es_ES')->monthName }}
                              {{ $pago->pagoMensual->anio }}</p>
                           @else
                           <p>{{ \Carbon\Carbon::parse($pago->fecha)->locale('es_ES')->isoFormat('MMMM') }}</p>
                           @endif
                        </td>
                        <td class="text-center">
                           <p>{{ $pago->monto }}bs.</p>
                        </td>
                        <td class="text-center">
                           <a href="{{ route('admin.pago.guardar.imprimir', [$pago->id]) }}">
                              <i class="bi bi-printer"></i>
                           </a>
                        </td>
                     </tr>
                     @endforeach
                     @else
                     <tr class="text-center">
                        <th class="text-black">No hay pagos registrados</th>
                     </tr>
                     @endif
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>