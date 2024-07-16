@extends('layouts.app')

@section('content')
<div class="position-relative iq-banner">
   <div class="iq-navbar-header" style="height: 180px;">
      <div class="container-fluid iq-container">
         <div class="row">
               <div class="col-md-12">
                  <div class="col-md-12">
                     <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                           <a type="button" class="btn btn-outline-primary active">Habilitados</a>
                           <a type="button" class="btn btn-outline-primary" href="{{ route('admin.cursos') }}" style="color: black">Materias</a>
                        </div>
                        @role('Admin')
                        <div class="mt-2 mt-md-0">
                           <a  href="{{ route('admin.tareas.criterios') }}" class="btn btn-primary">Criterios</a>
                        </div>
                        @endrole
                     </div>
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
  <div class="row">
     <div class="col-sm-12">
        <div class="card">
           <div class="card-body">
               <div class="flex-wrap d-flex justify-content-between align-items-center">
                  <p></p>
                  <button id="exportBtnMateriasHabilitados1" class="btn btn-link text-black">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M17 13v-13h-2v5h-2v-3h-2v7h-2v-9h-2v13h-6l11 11 11-11z"/>
                     </svg> Descargar
                  </button>
               </div>
            <br>
              <div class="table-responsive">
                 <table id="datatableMateriasHabilitados" class="table table-striped" data-toggle="data-table">
                    <thead>
                       <tr>
                          <th>Nombre</th>
                          <th>Docente</th>
                          <th>Aula</th>
                          <th>Modalidad</th>
                          <th>Horario</th>
                          <th>Estado</th>
                          <th></th>
                       </tr>
                    </thead>
                    <tbody>
                     @foreach ($cursos as $item)
                        <tr>
                           <td><p>{{ $item->curso->nombre }}</p></td>
                           <td><a href="{{ route('admin.'. $item->docente->persona->rol .'.show', [$item->docente->persona->id]) }}">{{ $item->docente->persona->nombre }} {{ $item->docente->persona->ap_paterno }} {{ $item->docente->persona->ap_materno }}</a></td>
                           <td><p>{{ $item->aula->codigo }}</p></td>
                           <td><p>{{ $item->curso->semestre->nombre }}</p></td>
                           <td><p>{{ $item->horario->turno }}</p></td>
                              @if ($item->estado == true)
                                 <td><p> <span class="badge rounded-pill bg-info text-white">Activo</span></p></td>
                              @else
                                 <td><p> <span class="badge rounded-pill bg-danger text-white">Materia Cerrada</span></p></td>
                              @endif
                           <td>
                              <div class="flex align-items-center list-user-action">
                                 <a class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver" href="{{ route('admin.cursos.show', [$item->id]) }}">
                                    <i class="bi bi-eye"></i>
                                 </a>
                                 @if ($item->estado) 
                                 <a class="btn btn-sm btn-icon btn-gray" data-bs-toggle="tooltip" data-bs-placement="top" title="Programar" href="{{ route('programar.materia', [$item->id]) }}">
                                    <i class="bi bi-check2-circle"></i>
                                 </a>
                                 <a class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"  href="{{ route('admin.asigando.edit', [$item->id]) }}">
                                    <i class="bi bi-pen"></i>
                                 </a>
                                 @endif
                                 
                                 @if ($item->estado == true)
                                    <a class="btn btn-sm btn-icon btn-danger" data-bs-placement="top" data-bs-toggle="modal" data-bs-target="#estadoConfirm{{ $item->id }}" data-itemid="{{ $item->id }}">
                                       <i class="bi bi-x-circle"></i>
                                    </a>
                                 @else
                                    <a class="btn btn-sm btn-icon btn-danger" data-bs-placement="top" data-bs-toggle="modal" data-bs-target="#estadoConfirm{{ $item->id }}" data-itemid="{{ $item->id }}">
                                       <i class="bi bi-file-arrow-up-fill"></i>
                                    </a>
                                 @endif
                              </div>
                           </td>
                        </tr>
                        @include('admin.cursos.widgets.modal_activos', ['itemId' => $item->id])
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