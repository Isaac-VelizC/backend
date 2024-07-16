@extends('layouts.app')

@section('content')
<div class="position-relative iq-banner">
    <div class="iq-navbar-header" style="height: 150px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                        <div>
                            <h4>{{ Breadcrumbs::render('recetas.show', $receta) }}</h4>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="row no-gutters">
                    <div class="col-md-8">
                        <div class="card-body">
                            <h4>{{ $receta->titulo }}</h4>
                            <p class="mt-2">{{ $receta->descripcion }}</p>
                            <div class="row">
                                <div class="d-flex justify-content-between mt-3 text-center">
                                    <div>
                                        <div>Ingredientes</div>
                                        <i class="bi bi-diagram-2"></i>
                                        <h5 class="mb-0">{{ count($receta->ingredientes) }}</h5>
                                    </div>
                                    <div>
                                        <div>Porciones</div>
                                        <i class="bi bi-calendar-x"></i>
                                        <h5 class="mb-0">{{ $receta->porcion }}</h5>
                                    </div>
                                    <div>
                                        <div>Tiempo</div>
                                        <i class="bi bi-alarm"></i>
                                        <h5 class="mb-0">{{ $receta->tiempo }}'</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-body text-center h-100 iq-single-card">
                            <a href="{{ asset($receta->imagen) }}">
                                <img src="{{ asset($receta->imagen) }}" alt="Foto" class="rounded" width="200">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center py-2">
                                <h5><strong>Ingredientes</strong></h5>
                            </div>
                            @if (count($receta->ingredientesReceta) > 0)
                            @foreach ($receta->ingredientesReceta as $ing)
                            <div class="d-flex align-items-center justify-content-between flex-wrap text-black">
                                <p>
                                    <img src="{{ asset('img/frutas-verduras.png')}}" alt="story-img"
                                        class="rounded-pill avatar-40">
                                    {{ $ing->ingrediente->nombre }}
                                </p>
                                <div class="d-flex align-items-center flex-wrap">
                                    <p>{{ $ing->cantidad }} {{ $ing->unida_media }}</p>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="card">
                                <div class="text-center">
                                    <p>La receta no tiene ingredientes</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center py-2">
                                <h5><strong>Pasos</strong></h5>
                            </div>
                            @if (count($receta->pasos) > 0)
                            @foreach ($receta->pasos as $item)
                            <div class="text-black p-3 flex-wrap align-items-start">
                                <span class="badge bg-warning rounded-pill">{{ $item->numero }}</span>
                                <h6>{{ $item->paso }}</h6>
                            </div>
                            @endforeach
                            @else
                            <div class="card">
                                <div class="text-center">
                                    <p>La receta no tiene pasos</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection