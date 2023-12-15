@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 215px;">
  <div class="iq-container">
      <div class="row">
          <div class="col-md-12">
              <div class="flex-wrap d-flex justify-content-between align-items-center">
                  <div>
                     <div class="btn-group" role="group" aria-label="Basic outlined example">
                        <a type="button" class="btn btn-outline-primary active">Cursos</a>
                        <a type="button" class="btn btn-outline-primary" href="{{ route('admin.cursos.activos') }}" style="color: black">Cursos Habilitados</a>
                     </div>
                  </div>
                  <div>
                     <a data-bs-toggle="modal" data-bs-target="#newCurso" class="btn btn-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                           <path d="M24 7v-2c0-2.761-2.238-5-5-5h-14c-2.761 0-5 2.239-5 5v2h10v2h-10v6h4v2h-4v2c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-2h-8v-2h8v-6h-5v-2h5zm-16 11c0 .552-.447 1-1 1s-1-.448-1-1v-4c0-.552.447-1 1-1s1 .448 1 1v4zm3 0c0 .552-.447 1-1 1s-1-.448-1-1v-4c0-.552.447-1 1-1s1 .448 1 1v4zm3 0c0 .552-.447 1-1 1s-1-.448-1-1v-4c0-.552.447-1 1-1s1 .448 1 1v4zm0-8c0 .552-.447 1-1 1s-1-.448-1-1v-4c0-.552.447-1 1-1s1 .448 1 1v4zm3 0c0 .552-.447 1-1 1s-1-.448-1-1v-4c0-.552.447-1 1-1s1 .448 1 1v4z"/>
                        </svg>
                        Nueva Materia
                     </a>
                 </div>
              </div>
          </div>
      </div>
  </div>
</div> 

@include('admin.cursos.widgets.form_create')

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
                  <a href="{{ route('export.cursos') }}" class="btn btn-link text-black">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M17 13v-13h-2v5h-2v-3h-2v7h-2v-9h-2v13h-6l11 11 11-11z"/>
                     </svg> Descargar
                  </a>
              </div>
              <br>
              <div class="table-responsive">
                 <table id="datatable" class="table table-striped" data-toggle="data-table">
                    <thead>
                       <tr>
                          <th>Nombre</th>
                          <th>Color</th>
                          <th>Semestre</th>
                          <th>Estado</th>
                          <th></th>
                       </tr>
                    </thead>
                    <tbody>
                     @foreach ($cursos as $item)
                        <tr>
                           <td><p>{{ $item->nombre }}</p></td>
                           <td><p><span class="badge" style="background-color: {{ $item->color }}">Color</span></p></td>
                           <td><p>{{ $item->semestre->nombre }}</p></td>
                           <td>
                                <p> <span class="badge rounded-pill 
                                @if ($item->estado == true)
                                bg-info text-white">Activo
                                @else
                                bg-danger text-white">Inactivo
                                @endif
                                </span></p>
                            </td>
                           <td>
                              <div class="flex align-items-center list-user-action">
                                 <a class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Asignar" href="{{ route('admin.asignar.curso', [$item->id]) }}">
                                       <i class="bi bi-person-gear"></i>
                                 </a>
                                 <a class="btn btn-sm btn-icon btn-warning" data-bs-toggle="modal" data-bs-placement="top" title="Edit" data-bs-target="#editCurso{{ $item->id }}" data-itemid="{{ $item->id }}">
                                       <i class="bi bi-pen"></i>
                                 </a>
                                 <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal" data-bs-placement="top" title="Delete" data-bs-target="#deleteConfirm{{ $item->id }}" data-itemid="{{ $item->id }}">
                                       <i class="bi bi-trash"></i>
                                 </a>
                              </div>
                           </td>
                        </tr>
                        @include('admin.cursos.widgets.modal_delete', ['itemId' => $item->id])
                        @include('admin.cursos.widgets.modal_edit', ['itemId' => $item->id])
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