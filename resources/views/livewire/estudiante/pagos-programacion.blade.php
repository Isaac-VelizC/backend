<div>
    <div class="col-sm-12">
        <div class="card">
           <div class="card-body p-0">
              <div class="table-responsive pricing pt-2">
                 <table class="table table-bordered mb-0">
                    <thead>
                       <tr>
                          @foreach ($metodos as $met)
                            <th>
                                <div>
                                    <div class="text-bold h5">{{ $met->nombre }}</div>
                                    <div class="d-flex justify-content-start align-items-center mt-4">
                                        <small>Bs.</small>
                                        <div class="mx-2 h4">{{ $met->monto }}</div>
                                        <small> / mo</small>
                                    </div>
                                    <button class="btn btn-primary rounded-pill mt-3 w-100" wire:click="formPago({{$met->id}})">Seleccionar</button>
                                </div>
                            </th>
                          @endforeach
                       </tr>
                    </thead>
                    <tbody>
                        <tr>
                           <th colspan="5" class="bg-light">Pagos</th>
                        </tr>
                        @if (count($pagos) > 0)
                           @foreach ($pagos as $pago)
                              <tr>
                                 <th scope="row">Payment 1</th>
                                 <td class="text-center">
                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M23 7L6.44526 17.8042C5.85082 18.1921 5.0648 17.9848 4.72059 17.3493L1 10.4798" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                                    </svg>
                                 </td>
                                 <td class="text-center active">
                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M23 7L6.44526 17.8042C5.85082 18.1921 5.0648 17.9848 4.72059 17.3493L1 10.4798" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                                    </svg>
                                 </td>
                                 <td class="text-center">
                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M23 7L6.44526 17.8042C5.85082 18.1921 5.0648 17.9848 4.72059 17.3493L1 10.4798" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                                    </svg>
                                 </td>
                                 <td class="text-center">
                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M23 7L6.44526 17.8042C5.85082 18.1921 5.0648 17.9848 4.72059 17.3493L1 10.4798" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                                    </svg>
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
                  // Abrir el modal
                  $('#formPago').modal('show');
            });
         </script>
      @endscript
</div>
