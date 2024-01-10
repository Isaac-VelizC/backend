@extends('layouts.app')

@section('content')

<div class="position-relative iq-banner">
   <div class="iq-navbar-header" style="height: 215px;">
      <div class="container-fluid iq-container">
         <div class="row">
               <div class="col-md-12">
                  <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                     <div>
                        <h1>Listado de Pagos</h1>
                     </div>
                     <a class="btn btn-light" href="{{ route('admin.create.pago') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                           <path d="M4 8v12h20v-12h-20zm10 10c-2.209 0-4-1.791-4-4s1.791-4 4-4 4 1.791 4 4-1.791 4-4 4zm.2-2.021v.421h-.4v-.4c-.414-.007-.843-.105-1.2-.291l.183-.657c.382.148.891.305 1.29.216.46-.104.555-.577.046-.806-.373-.172-1.512-.321-1.512-1.296 0-.545.415-1.034 1.193-1.141v-.425h.4v.407c.289.007.615.058.978.168l-.146.658c-.307-.107-.647-.206-.977-.185-.595.035-.648.551-.232.767.685.321 1.578.561 1.578 1.418 0 .687-.538 1.054-1.201 1.146zm6.8-9.979h-19v11h-2v-13h21v2z"/>
                        </svg> Registrar Pago
                     </a>
                  </div>
               </div>
         </div>
      </div>
      <div class="iq-header-img">
         <img src="{{ asset('img/portada.jpg') }}" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
      </div>
   </div>
</div>

<div class="conatiner-fluid content-inner mt-n5 py-0">
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
                            <th>Nombre Completo</th>
                            <th>Tipo Pago</th>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th></th>
                         </tr>
                      </thead>
                      <tbody>
                       @foreach ($pagos as $item)
                          <tr>
                             <td>{{ $item->estudiante->persona->nombre }} {{ $item->estudiante->persona->ap_paterno }} {{ $item->estudiante->persona->ap_materno }}</td>
                             <td>{{ $item->metodoPago->nombre }}</td>
                             <td>{{ \Carbon\Carbon::parse($item->fecha)->locale('es_ES')->isoFormat('LL') }}</td>
                             <td>{{ $item->monto }}Bs.</td>
                             <td>
                                <div class="flex align-items-center list-user-action">
                                   <a href="{{ route('admin.pago.guardar.imprimir', [$item->id]) }}" title="Imprimir">
                                      <i class="bi bi-printer"></i>
                                   </a>
                                   <a data-bs-toggle="modal" data-bs-target="#deleteConfirm" data-curso-id="{{ $item->id }}">
                                      <i class="bi bi-trash"></i>
                                   </a>
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
@endsection