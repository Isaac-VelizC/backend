@extends('layouts.app')

@section('content')
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
                            <!--div class="mb-5 pt-2">
                                <p class="line-around text-gray mb-0"><span class="line-around-1">Por: </span></p>
                            </div-->
                            <div class="row">
                                <div class="d-flex justify-content-between mt-3 text-center">
                                    <div>
                                        <div>Ingredientes</div>
                                        <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <h5 class="mb-0">{{ count($receta->ingredientes) }}</h5>
                                    </div>
                                    <div>
                                        <div>Porciones</div>
                                        <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <h5 class="mb-0">{{ $receta->porcion }}</h5>
                                    </div>
                                    <div>
                                        <div>Tiempo</div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <path d="M22 14c0 5.523-4.478 10-10 10s-10-4.477-10-10 4.478-10 10-10 10 4.477 10 10zm-2 0c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8 8-3.589 
                                                    8-8zm-6-11.819v-2.181h-4v2.181c1.408-.238 2.562-.243 4 0zm6.679 3.554l1.321-1.321-1.414-1.414-1.407 1.407c.536.402 1.038.844 1.5 1.328zm-8.679 
                                                    2.265v6h6c0-3.309-2.691-6-6-6z"/>
                                        </svg>
                                        <h5 class="mb-0">{{ $receta->tiempo }}'</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-body text-center h-100 iq-single-card">
                            <a href="{{ asset($receta->imagen) }}">
                                <img src="{{ asset($receta->imagen) }}" alt="" class="theme-color-default-img rounded portada-300">
                            </a>
                        </div>
                    </div>
                </div>                  
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills  nav-fill" data-toggle="slider-tab" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="ingrediente-tab" data-bs-toggle="tab" data-bs-target="#pills-ingrediente1" type="button" role="tab" aria-controls="ingrediente" aria-selected="true">Ingredientes</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pasos-tab" data-bs-toggle="tab" data-bs-target="#pills-pasos1" type="button" role="tab" aria-controls="pasos" aria-selected="false">Pasos</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-ingrediente1" role="tabpanel" aria-labelledby="pills-ingrediente-tab1">
                            <div class="card">
                                <div class="card-body">
                                    @if (count($receta->ingredientesReceta) > 0)
                                        @foreach ($receta->ingredientesReceta as $ing)
                                            <div class="d-flex align-items-center justify-content-between flex-wrap text-black">
                                                <p>
                                                    <img src="{{ asset('img/frutas-verduras.png')}}" alt="story-img" class="rounded-pill avatar-40">
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
                        <div class="tab-pane fade" id="pills-pasos1" role="tabpanel" aria-labelledby="pills-pasos-tab1">
                            @if (count($receta->pasos) > 0)
                                @foreach ($receta->pasos as $item)
                                    <div class="card text-black" style="background: #fff08e">
                                        <div class="card-body">
                                            <span class="badge bg-warning rounded-pill">{{ $item->numero }}</span>
                                            <h6>{{ $item->paso }}</h6>
                                        </div>
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
</div>
@endsection
