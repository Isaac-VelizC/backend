@extends('layouts.app')

@section('content')

<div class="position-relative iq-banner">
   <div class="iq-navbar-header" style="height: 150px;">
      <div class="container-fluid iq-container">
         <div class="row">
            <div class="col-md-12">
               <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                  <div>
                     <h5>{{ Breadcrumbs::render( 'Pagos.list') }}</h5>
                  </div>
                  <a class="btn btn-primary" href="{{ route('admin.create.pago') }}">
                     Registrar
                  </a>
               </div>
            </div>
         </div>
      </div>
      <div class="iq-header-img">
         <img src="{{ asset('img/fondo1.jpg') }}" alt="header" class="img-fluid w-100 h-100 animated-scaleX">
      </div>
   </div>
</div>

<div class="conatiner-fluid content-inner mt-n5 py-0">
   @role('Admin')
      <div class="row">
         <div class="col-md-12 col-lg-12">
            <div class="row row-cols-1">
               <div class="overflow-hidden">
                  <div class="card">
                     <a href="{{ route('admin.pagos.historial') }}">
                        <div class="card-body">
                           <div class="progress-widget">
                              <div class="rounded p-3 bg-soft-primary">
                                 <i class="bi bi-calendar-check"></i>
                              </div>
                              <div class="progress-detail">
                                 <p  class="mb-2">Totales del mes de {{ $mesActual }}</p>
                                 <h6 class="counter">Estudiantes activos {{ $estudiantes }} en el mes de {{ $mesActual }} </h6>
                              </div>
                           </div>
                        </div>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   @endrole
   @if(session('success'))
      <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
         <span>{{ session('success') }}</span>
         <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
   @endif
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-body">
               <div class="flex-wrap d-flex justify-content-between align-items-center">
                  <p></p>
                  <button id="exportBtnPagos1" class="btn btn-link text-black">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M17 13v-13h-2v5h-2v-3h-2v7h-2v-9h-2v13h-6l11 11 11-11z"/>
                     </svg> Descargar
                  </button>
               </div>
               <div class="table-responsive">
                  <table id="datatablePagos" class="table table-striped" data-toggle="data-table">
                     <thead>
                        <tr>
                           <th>Codigo</th>
                           <th>Estudiante</th>
                           <th>Mes de Pago</th>
                           <th>Fecha</th>
                           <th>Monto</th>
                           <th></th>
                        </tr>
                     </thead>
                     <tbody>
                     @foreach ($pagos as $item)
                        <tr>
                           <td>{{ $item->codigo }}</td>
                           <td> <a href="{{ route('admin.E.show', $item->estudiante->persona->id) }}">
                           {{ $item->estudiante->persona->nombre }} {{ $item->estudiante->persona->ap_paterno }} {{ $item->estudiante->persona->ap_materno }}
                           </a></td>
                           <td>
                              @if ($item->pagoMensual)
                                 {{ \Carbon\Carbon::create()->month($item->pagoMensual->mes)->locale('es_ES')->monthName }}
                              @else
                                 {{ \Carbon\Carbon::parse($item->fecha)->locale('es_ES')->isoFormat('MMMM') }}
                              @endif
                           </td>
                           <td>{{ \Carbon\Carbon::parse($item->fecha)->locale('es_ES')->isoFormat('LL') }}</td>
                           <td>{{ $item->monto }}Bs.</td>
                           <td>
                              <div class="flex align-items-center list-user-action">
                                 <a href="#" title="Detalles" data-bs-toggle="modal" data-bs-target="#detallePago" data-pago-id="{{ $item->id }}">
                                    <i class="bi bi-info-circle"></i>
                                </a>
                                 <a href="{{ route('admin.pago.guardar.imprimir', [$item->id]) }}" title="Imprimir">
                                    <i class="bi bi-printer"></i>
                                 </a>
                                 <a href="{{ route('admin.pagos.edit', [$item->id]) }}" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                 </a>
                                 <!--a data-bs-toggle="modal" data-bs-target="#deleteConfirm" data-curso-id="{{ $item->id }}">
                                    <i class="bi bi-x-circle"></i>
                                 </a-->
                              </div>
                           </td>
                        </tr>
                     @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="detallePago" tabindex="-1" aria-labelledby="detallePagoLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered  modal-lg">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="detallePagoLabel">Detalles del Pago</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
            <div class="modal-body"></div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
           </div>
       </div>
   </div>
</div>

<script>
   var modalDetalle = document.getElementById('detallePago');
   modalDetalle.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var pagoId = button.getAttribute('data-pago-id');
      axios.get('/obtener/detalles/pago/' + pagoId)
         .then(function (response) {
            var pago = response.data.pago;
            var mensuales = response.data.mesuales;
            var modalBody = modalDetalle.querySelector('.modal-body');
            console.log(mensuales);
            // Construir la tabla HTML
            var tableHtml = `
               <p><strong>Lugar y fecha</strong> <span class="font-weight-normal">Potosí, ${pago.fecha} hrs. ${pago.hora}</span></p>
               <p><strong>Señores</strong> <span>${pago.estudiante}</span></p>
               <div class="d-flex justify-content-between">
                  <p class="m-0"><strong>NIT/CI</strong> <span>${pago.nit}</span></p>
                  <p class="m-0">${pago.tipo}</p>
               </div>
               <table class="table">
                  <thead>
                     <tr>
                        <th>CODIGO</th>
                        <th>DESCRIPCIÓN</th>
                        <th>MES</th>
                        <th>P.UNIT</th>
                        <th>SUB TOTAL</th>
                     </tr>
                  </thead>
                  <tbody>`;

            // Recorrer los elementos de la variable mensuales
            mensuales.forEach(function(item) {
               tableHtml += `
                  <tr>
                     <td>${item.codigo}</td>
                     <td>${item.descripcion}</td>
                     <td>${item.mes}</td>
                     <td>${item.monto}</td>
                     <td>${item.monto}</td>
                  </tr>`;
            });

            tableHtml += `
                  </tbody>
               </table>`;

            // Insertar la tabla HTML en el modal body
            modalBody.innerHTML = tableHtml;
         })
         .catch(function (error) {
            console.error('Error al cargar los detalles del pago:', error);
         });
   });
</script>

@endsection