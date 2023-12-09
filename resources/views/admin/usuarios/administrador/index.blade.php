@extends('layouts.app')

@section('content')

<div class="position-relative iq-banner">
   <div class="iq-navbar-header" style="height: 215px;">
      <div class="container-fluid iq-container">
         <div class="row">
            <div class="col-md-12">
               <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                  <div>
                     <h1>Trabajadores!</h1>
                  </div>
                  <div>
                     <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Nuevo Personal</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="iq-header-img">
         <img src="{{ asset('img/fondo2.jpg') }}" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
      </div>
   </div>
</div>

@include('admin.usuarios.widgets.form_modal_create', ['formType' => $formType])

<div class="conatiner-fluid content-inner mt-n5 py-0">
   @if(session('errors'))
      <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
         <span>La validación ha fallado debido a los siguientes errores:</span>
         <ul>
               @foreach (session('errors')->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
         </ul>
         <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
   @endif
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
                          <th>C.I.</th>
                          <th>E-mail</th>
                          <th>Telefono</th>
                          <th>Rol</th>
                          <th>Estado</th>
                          <th></th>
                       </tr>
                    </thead>
                    <tbody>
                      @foreach ($personals as $item)
                        <tr>
                           <td>
                              <a href="{{ route('admin.P.show', [$item->id]) }}">
                                 <p>{{ $item->persona->nombre }} {{ $item->persona->ap_paterno }} {{ $item->persona->ap_materno }}</p>
                              </a>
                           </td>
                            <td>
                              <p>{{ $item->persona->ci }}</p>
                            </td>
                            <td>
                              <p><a href="#">{{ $item->persona->user->email }}</a></p>
                            </td>
                            <td>
                              <p>{{ $item->persona->numTelefono->numero }}</p>
                            </td>
                            <td><p>{{ $item->persona->user->getRoleNames()->first() }}</p></td>
                           <td>
                              @if ($item->estado == true)
                                 <p> <span class="badge rounded-pill bg-info text-white">Activo</span></p>
                              @else
                                 <p> <span class="badge rounded-pill bg-danger text-white">Inactivo</span></p>
                              @endif
                           </td>
                            <td>
                              <div class="flex align-items-center list-user-action">
                                 @if ($item->estado == true)
                                    <a class="btn btn-sm btn-icon btn-danger" data-bs-placement="top" data-bs-toggle="modal" data-bs-target="#deleteConfirm{{ $item->id }}">
                                       <i class="bi bi-file-arrow-down-fill"></i> Dar de baja
                                    </a>
                                 @else
                                    <a class="btn btn-sm btn-icon btn-danger" data-bs-placement="top" title="Dar de Alta" data-bs-toggle="modal" data-bs-target="#deleteConfirm{{ $item->id }}">
                                       <i class="bi bi-file-arrow-up-fill"></i> Dar de alta
                                    </a>
                                  @endif
                              </div>
                            </td>
                        </tr>
                        @include('admin.usuarios.widgets.modal_dar_baja', ['modalId' => $item->id, 'id' => $item->persona->id, 'tipo' => $item->persona->rol])
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