@extends('layouts.app')

@section('content')
<div class="position-relative iq-banner">>
   <div class="iq-navbar-header" style="height: 215px;">
      <div class="container-fluid iq-container">
            <div class="row">
               <div class="col-md-12">
                  <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <h1 style="color: black">Estudiantes</h1>
                        <a class="btn btn-light text-black" href="{{ route('admin.inscripcion') }}">
                           <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                              <path d="M24 21h-3l1-3h1l1 3zm-12.976-4.543l8.976-4.575v6.118c-1.007 2.041-5.607 3-8.5 3-3.175 0-7.389-.994-8.5-3v-6.614l8.024 5.071zm11.976.543h-1v-7.26l-10.923 5.568-11.077-7 12-5.308 11 6.231v7.769z"/>
                           </svg> Inscribir
                        </a>
                  </div>
               </div>
            </div>
      </div>
      <div class="iq-header-img">
         <img src="{{ asset('img/fondo2.jpg') }}" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
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
                        <th>Fecha Nacimiento</th>
                        <th>Estado</th>
                        <th></th>
                       </tr>
                    </thead>
                    <tbody>
                      @foreach ($estudiantes as $item)
                        <tr>
                            <td><p><a href="{{ route('admin.E.show', $item->persona->id) }}">{{ $item->persona->nombre }} {{$item->persona->ap_paterno}} {{$item->persona->ap_materno}}</a></p></td>
                            <td><p>{{ $item->persona->email }}</p></td>
                            <td><p>{{ $item->persona->ci }}</p></td>
                            <td><p>{{ $item->fecha_nacimiento }}</p></td>
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