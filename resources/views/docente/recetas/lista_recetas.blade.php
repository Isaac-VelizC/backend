@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 80px;"></div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="card"> 
                @if(session('success'))
                    <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
                        <span>{{ session('success') }}</span>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
                        <span>{{ session('error') }}</span>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card-header text-center">
                    <div class="header-title">
                        <h4 class="card-title">Recetas Generadas</h4>
                    </div>
                </div>
                <div class="card-body">
                    <hr>
                    @if ($lista)
                        @foreach ($lista as $item)
                            {{-- Acceder directamente al array --}}
                            @php
                                $receta = $item->receta;
                            @endphp
                
                            {{-- Comprobar si $receta es un array y tiene la clave 'titulo' --}}
                            @if (is_array($receta) && array_key_exists('titulo', $receta))
                                <h4>{{ $receta['titulo'] }}</h4>
                            @endif
                
                            {{-- Comprobar si $receta es un array y tiene la clave 'ingredientes' --}}
                            @if (is_array($receta) && array_key_exists('ingredientes', $receta))
                                <ul>
                                    @foreach ($receta['ingredientes'] as $ingrediente)
                                        <li>{{ $ingrediente }}</li>
                                    @endforeach
                                </ul>
                            @endif
                
                            {{-- Comprobar si $receta es un array y tiene la clave 'pasos' --}}
                            @if (is_array($receta) && array_key_exists('pasos', $receta))
                                <ol>
                                    @foreach ($receta['pasos'] as $paso)
                                        <li>{{ $paso }}</li>
                                    @endforeach
                                </ol>
                            @endif
                
                        @endforeach
                    @endif
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection