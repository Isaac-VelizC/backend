@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 215px;">
  <div class="container-fluid iq-container">
      <div class="row">
          <div class="col-md-12">
              <div class="flex-wrap d-flex justify-content-between align-items-center">
                  <div>
                     <h1 style="color: black">Todos los Usuarios</h1>
                  </div>
              </div>
          </div>
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
              <div class="table-responsive">
                 <table id="datatable" class="table table-striped" data-toggle="data-table">
                    <thead>
                       <tr>
                        <th>Nombre Completo</th>
                        <th>E-mail</th>
                        <th>C.I.</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th></th>
                       </tr>
                    </thead>
                    <tbody>
                      @foreach ($users as $item)
                        <tr>
                            <td><p>{{ $item->nombre }} {{ $item->ap_paterno }} {{ $item->ap_materno }}</p></td>
                            <td><p><a href="#0">{{ $item->email }}</a></p></td>
                            <td><p>{{ $item->ci }}</p></td>
                            <td><p>{{ $item->user->getRoleNames()->first() }}</p></td>
                           <td>
                              @if ($item->estado == true)
                                 <p> <span class="badge rounded-pill bg-info text-white">Activo</span></p>
                              @else
                                 <p> <span class="badge rounded-pill bg-danger text-white">Inactivo</span></p>
                              @endif
                           </td>
                            <td>
                              <div class="flex align-items-center list-user-action">
                                 <a data-bs-toggle="tooltip" data-bs-placement="top" title="Registrar"  href="#">
                                    <i class="bi bi-person-fill-gear"></i>
                                 </a>
                                 <a data-bs-toggle="tooltip" data-bs-placement="top" title="Ver"  href="{{ route('admin.'.$item->tipo_pers.'.show', [$item->id]) }}">
                                    <i class="bi bi-eye-fill"></i>
                                 </a>
                                 @if ($item->estado == true)
                                    <a data-bs-placement="top" data-bs-toggle="modal" data-bs-target="#deleteConfirm{{ $item->id }}">
                                       <i class="bi bi-file-arrow-down-fill"></i>
                                    </a>
                                 @else
                                    <a data-bs-placement="top" title="Dar de Alta" data-bs-toggle="modal" data-bs-target="#deleteConfirm{{ $item->id }}">
                                       <i class="bi bi-file-arrow-up-fill"></i>
                                    </a>
                                 @endif
                              </div>
                            </td>
                        </tr>
                        @include('admin.usuarios.modal_de_baja', ['modalId' => $item->id, 'id' => $item->id, 'tipo' => $item->rol])
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