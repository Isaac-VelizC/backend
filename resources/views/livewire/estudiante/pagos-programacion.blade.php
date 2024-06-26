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
                           <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path d="M23 7L6.44526 17.8042C5.85082 18.1921 5.0648 17.9848 4.72059 17.3493L1 10.4798"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                           </svg>
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
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                 <path
                                    d="M20 5v-4h-16v4h-4v14h2.764l2.001-4h14.472l2 4h2.763v-14h-4zm-14-2h12v2h-12v-2zm16 13.055l-1.527-3.055h-16.944l-1.529 3.056v-9.056h20v9.055zm-4 
                                          .945l3 6h-18l3-6h2.203l-1.968 4h11.528l-1.956-4h2.193zm3-8.5c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5z" />
                              </svg>
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
      @include('admin.pagos.widgets.modal_form')
   </div>
   @script
   <script>
      $wire.on('modalPago', (event) => {
                  $('#formPago').modal('show');
            });
   </script>
   @endscript
</div>