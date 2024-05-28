@extends('layouts.app')

@section('content')

<div class="position-relative iq-banner">
    <div class="iq-navbar-header" style="height: 200px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                        <div>
                            <h4>{{ Breadcrumbs::render('Pagos.historial', $nombreMes) }}</h4>
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
        <div class="col-lg-6">
            <div class="row">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <span>Total de recaudación del mes {{ $nombreMes }}</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="border rounded p-3 bg-soft-primary me-3">
                                    <svg class="icon-24" xmlns="http://www.w3.org/2000/svg" width="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h2><span class="counter">{{ $totalMonto ?? 0 }}</span> Bs.</h2>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach($pagosPorMetodo as $detalleMetodo)
                    <div class="col-lg-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span>{{ $detalleMetodo['tipo'] }}</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="border rounded p-3 bg-soft-primary me-3">
                                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M19 3H5A2 2 0 0 0 3 5V19A2 2 0 0 0 5 21H19A2 2 0 0 0 21 19V5A2 2 0 0 0 19 3M5 19V17H8.13A4.13 4.13 0 0 0 9.4 19M19 19H14.6A4.13 4.13 0 0 0 15.87 17H19M19 15H14V16A2 2 0 0 1 10 16V15H5V5H19Z"></path>
                                            </svg>
                                        </div>
                                        <h2><span class="counter">{{ $detalleMetodo['monto_total'] ?? 0 }}</span> Bs.</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Estudiantes que no pagaron del mes</h4>
                    </div>
                </div>
                <div class="card-body">
                    @if (count($estudiantesSinPago) > 0)
                        @foreach($estudiantesSinPago as $metodoPago)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $metodoPago['metodo_pago'] }} : {{ $metodoPago['cantidad'] }}</h5>
                                    @if (count($metodoPago['estudiantes']) > 0)
                                        @foreach($metodoPago['estudiantes'] as $estudiante)
                                            <div>{{ $estudiante }}</div>
                                        @endforeach
                                    @else
                                        <div class="text-muted">No hay estudiantes</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center">No hay estudiantes</div>
                    @endif                    
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection