@extends('layouts.app')

@section('content')
<style>
   .input-file{
  display:none;  
}
</style>
<div class="position-relative iq-banner">
   <div class="iq-navbar-header" style="height: 215px;">
      <div class="container-fluid iq-container">
            <div class="row">
               <div class="col-md-12">
                  <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <h5 class="text-black">{{ Breadcrumbs::render('Estudiantes') }}</h5>
                        <a class="btn btn-primary" href="{{ route('admin.inscripcion') }}">
                           Inscribir
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
               <div class="flex-wrap d-flex gap-2 align-items-center">
                  <form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <input type="file" name="file" required class='input-file' id="input_file" style="display: none;">
                     <button type="submit" id="submit_btn" style="display: none;"></button>
                     <i class="bi bi-arrow-bar-up btn btn-secondary btn-sm" id='input_btn'></i>
                 </form>
                  <i id="exportBtnEstudiantes1" class="bi bi-arrow-bar-down btn btn-primary btn-sm"></i>
               </div>
            </div>
            <hr>
              <div class="table-responsive">
                 <table id="datatableEstudiantes" class="table table-striped" data-toggle="data-table">
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
                            <td><a href="mailto:{{ $item->persona->email}}">{{ $item->persona->email }}</a></td>
                            <td><p>{{ $item->persona->ci }}</p></td>
                            <td><p>{{ $item->fecha_nacimiento }}</p></td>
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
<script>
   document.getElementById('input_btn').addEventListener('click', function() {
       document.getElementById('input_file').click();
   });

   document.getElementById('input_file').addEventListener('change', function() {
       document.getElementById('submit_btn').click();
   });
</script>
@endsection