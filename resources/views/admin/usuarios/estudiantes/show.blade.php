@extends('layouts.app')

@section('content')
<div class="position-relative iq-banner">
    <div class="iq-navbar-header" style="height: 150px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                        <div>
                            <h4>{{ Breadcrumbs::render('Estudiantes.edit', $estudiante) }}</h4>
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
    <div class="text-black">
       <div class="row">
          <div class="col-xl-3 col-lg-4">
             <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <div class="user-profile">
                            <img src="{{ asset($estudiante->photo != 'user.png' ? 'storage/' . $estudiante->photo : 'img/user.png') }}" alt="profile-img" class="rounded-pill avatar-130 img-fluid">
                        </div>
                        <p class="d-inline-block pl-3"> {{ $estudiante->user->getRoleNames()->first() }}</p>
                     </div>
                     <div class="text-warning text-center">
                        <strong>Contraseña por defecto</strong>
                        <small>igla.{{ $estudiante->ci }}</small>
                     </div>
                   @livewire('admin.estudiante-password', ['id' => $estudiante->id])
                </div>
             </div>
          </div>
          <div class="col-xl-9 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="bd-example">
                        <ul class="nav nav-pills" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#pills-home1" type="button" role="tab" aria-controls="home" aria-selected="true">Estudiante</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#pills-profile1" type="button" role="tab" aria-controls="profile" aria-selected="false">Contacto</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#pills-contact1" type="button" role="tab" aria-controls="contact" aria-selected="false">Materias</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="calificaciones-tab" data-bs-toggle="tab" data-bs-target="#pills-calificaciones1" type="button" role="tab" aria-controls="calificaciones" aria-selected="false">Calificaciones</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pagos-tab" data-bs-toggle="tab" data-bs-target="#pills-pagos1" type="button" role="tab" aria-controls="pagos" aria-selected="false">Pagos</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home1" role="tabpanel" aria-labelledby="pills-home-tab1">
                                @include('admin.usuarios.estudiantes.components.info_estud')
                            </div>
                            <div class="tab-pane fade" id="pills-profile1" role="tabpanel" aria-labelledby="pills-profile-tab1">
                                @livewire('admin.estudiante-contacto', ['estudiante' => $estudiante->estudiante->id])
                            </div>
                            <div class="tab-pane fade" id="pills-contact1" role="tabpanel" aria-labelledby="pills-contact-tab1">
                                @livewire('estudiante.materia-semestre', ['id' => $est->id])
                            </div>
                            <div class="tab-pane fade" id="pills-calificaciones1" role="tabpanel" aria-labelledby="pills-calificaciones-tab1">
                                @livewire('estudiante.show-calificaciones', ['id' => $est->id])
                            </div>
                            <div class="tab-pane fade" id="pills-pagos1" role="tabpanel" aria-labelledby="pills-pagos-tab1">
                                @livewire('estudiante.pagos-programacion', ['id' => $est->id])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
       </div>
    </div>
</div>
@endsection