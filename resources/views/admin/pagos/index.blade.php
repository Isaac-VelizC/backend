@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 215px;">
    <div class="container-fluid iq-container">
        <div class="row">
            <div class="col-md-12">
                <div class="flex-wrap d-flex justify-content-between align-items-center">
                    <div>
                       <h1 style="color: black">Listado de Pagos</h1>
                    </div>
                    <a type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#formPago">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M4 8v12h20v-12h-20zm10 10c-2.209 0-4-1.791-4-4s1.791-4 4-4 4 1.791 4 4-1.791 4-4 4zm.2-2.021v.421h-.4v-.4c-.414-.007-.843-.105-1.2-.291l.183-.657c.382.148.891.305 1.29.216.46-.104.555-.577.046-.806-.373-.172-1.512-.321-1.512-1.296 0-.545.415-1.034 1.193-1.141v-.425h.4v.407c.289.007.615.058.978.168l-.146.658c-.307-.107-.647-.206-.977-.185-.595.035-.648.551-.232.767.685.321 1.578.561 1.578 1.418 0 .687-.538 1.054-1.201 1.146zm6.8-9.979h-19v11h-2v-13h21v2z"/>
                     </svg> Registrar Pago
                  </a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.pagos.widgets.modal_form')
  
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
                <div class="table-responsive">
                   <table id="datatable" class="table table-striped" data-toggle="data-table">
                      <thead>
                         <tr>
                            <th>Nombre</th>
                            <th>Docente</th>
                            <th>Aula</th>
                            <th>Modalidad</th>
                            <th>Horario</th>
                            <th>Estado</th>
                            <th>Tags</th>
                         </tr>
                      </thead>
                      <tbody>
                       @foreach ($pagos as $item)
                          <tr>
                             <td><p>{{ $item->nombre }}</p></td>
                             <td>
                             <p><a href="#0">{{ $item->nombre }} {{ $item->ap_paterno }} {{ $item->ap_materno }}</a></p>
                             </td>
                             <td>
                             <p>{{ $item->nombre }}</p>
                             </td>
                             <td>
                             <p>{{ $item->nombre }}</p>
                             </td>
                             <td>
                              <p>{{ $item->horarios }}</p>
                              </td>
                              <td>
                                @if ($item->estado == true)
                                   <p> <span class="badge rounded-pill bg-info text-white">Activo</span></p>
                                @else
                                   <p> <span class="badge rounded-pill bg-danger text-white">Inactivo</span></p>
                                @endif
                              </td>
                             <td>
                                <div class="flex align-items-center list-user-action">
                                   <a href="{{ route('admin.cursos.show', [$item->id]) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Asignar">
                                      <i class="bi bi-eye"></i>
                                   </a>
                                   <a data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"  href="{{ route('admin.asigando.edit', [$item->id]) }}">
                                      <i class="bi bi-pen"></i>
                                   </a>
                                   <a data-bs-placement="top" data-bs-toggle="modal" data-bs-target="#deleteConfirm" data-curso-id="{{ $item->id }}">
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