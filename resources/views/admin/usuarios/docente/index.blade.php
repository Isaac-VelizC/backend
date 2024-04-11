@extends('layouts.app')

@section('content')

<div class="position-relative iq-banner">
    <div class="iq-navbar-header" style="height: 150px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                        <h5>{{ Breadcrumbs::render('Docentes') }}</h5>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Nuevo Docente</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="iq-header-img">
            <img src="{{ asset('img/fondo2.jpg') }}" alt="header" class="img-fluid w-100 h-100 animated-scaleX">
        </div>
    </div>
</div>

@if ($formType)
   @include('admin.usuarios.widgets.form_modal_create', ['formType' => $formType])
@else
   <p>No hay existe la variable</p>
@endif

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
                <div class="flex-wrap d-flex justify-content-between align-items-center">
                    <p></p>
                    <button id="exportBtnDocentes1" class="btn btn-link text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M17 13v-13h-2v5h-2v-3h-2v7h-2v-9h-2v13h-6l11 11 11-11z"/>
                    </svg> Descargar
                    </button>
                </div>
              <div class="table-responsive">
                 <table id="datatableDocentes" class="table table-striped" data-toggle="data-table">
                    <thead>
                       <tr>
                            <th>Nombre Completo</th>
                            <th>E-mail</th>
                            <th>C.I.</th>
                            <th>Telefono</th>
                            <th>Estado</th>
                            <td></td>
                       </tr>
                    </thead>
                    <tbody>
                        @if (count($docentes) > 0)
                            @foreach ($docentes as $item)
                            <tr>
                                <td><p><a href="{{ route('admin.D.show', [$item->id]) }}">{{ $item->nombre }} {{$item->ap_paterno}} {{$item->ap_materno}}</a></p></td>
                                <td><p>{{ $item->email }}</p></td>
                                <td><p>{{ $item->ci }}</p></td>
                                <td><p>{{ $item->numero }}</p></td>
                                @if ($item->estado == true)
                                    <td><p> <span class="badge rounded-pill bg-info text-white">Activo</span></p></td>
                                @else
                                    <td><p> <span class="badge rounded-pill bg-danger text-white">Inactivo</span></p></td>
                                @endif
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
                            @include('admin.usuarios.widgets.modal_dar_baja', ['modalId' => $item->id, 'id' => $item->id, 'tipo' => $item->rol])
                            @endforeach
                        @endif
                    </tbody>
                 </table>
              </div>
           </div>
        </div>
     </div>
  </div>
</div>
@endsection