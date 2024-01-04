@extends('layouts.app')

@section('content')
    <div class="position-relative iq-banner">
        <div class="iq-navbar-header" style="height: 215px;">
            <div class="container-fluid iq-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                            <div>
                                <h1>{{ $curso->curso->nombre }}</h1>
                                <p>{{ $curso->curso->descripcion }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-header-img">
                <img src="{{ asset('img/fondo1.jpg') }}" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
            </div>
        </div>
     </div>
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
        @if(session('success'))
            <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="bd-example">
                            <ul class="nav nav-pills" data-toggle="slider-tab" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="trabajo-tab" data-bs-toggle="tab" data-bs-target="#pills-trabajo1" type="button" role="tab" aria-controls="trabajo" aria-selected="true">Trabajos</button>
                                </li>
                                @if ($role->name == 'Docente')
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="asistencia-tab" data-bs-toggle="tab" data-bs-target="#pills-asistencia1" type="button" role="tab" aria-controls="asistencia" aria-selected="false">Asistencia</button>
                                    </li>
                                @endif
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="calificacion-tab" data-bs-toggle="tab" data-bs-target="#pills-calificacion1" type="button" role="tab" aria-controls="calificacion" aria-selected="false">Calificaciones</button>
                                </li>
                                @if ($role->name == 'Docente')
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="config-tab" data-bs-toggle="tab" data-bs-target="#pills-config1" type="button" role="tab" aria-controls="config" aria-selected="false">Configuración</button>
                                    </li>
                                @endif
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-trabajo1" role="tabpanel" aria-labelledby="pills-trabajo-tab1">
                                    @livewire('docente.trabajos', ['id' => $curso->id])
                                </div>
                                @if ($role->name == 'Docente')
                                    <div class="tab-pane fade" id="pills-asistencia1" role="tabpanel" aria-labelledby="pills-asistencia-tab1">
                                        @livewire('docente.asistencia', ['id' => $curso->id])
                                    </div>
                                @endif
                                <div class="tab-pane fade" id="pills-calificacion1" role="tabpanel" aria-labelledby="pills-calificacion-tab1">
                                    @livewire('docente.calificaciones', ['id' => $curso->id])
                                </div>
                                @if ($role->name == 'Docente')
                                    <div class="tab-pane fade" id="pills-config1" role="tabpanel" aria-labelledby="pills-config-tab1">
                                        @include('docente.cursos.widgets.configuracion')
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection