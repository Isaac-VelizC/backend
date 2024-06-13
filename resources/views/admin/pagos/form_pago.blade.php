@extends('layouts.app')

@section('content')
<div class="position-relative iq-banner">
    <div class="iq-navbar-header text-black" style="height: 180px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <h5>{{ $isEditing ? Breadcrumbs::render('Pagos.editar', $pago) : Breadcrumbs::render('Pagos.create') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="iq-header-img">
            <img src="{{ asset('img/fondo1.jpg') }}" alt="header"
                class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
        </div>
    </div>
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            @if(session('error'))
            <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade"
                role="alert">
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="new-user-info">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Formulario de pago</h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <form class="needs-validation" novalidate action="{{ $isEditing ? route('admin.update.pago', $pago->id) : route('admin.store.pago') }}" method="POST">
                                    @csrf
                                    @if ($isEditing)
                                        @method('PUT')
                                    @endif
                                    <div class="col-sm-12 col-lg-12">
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label class="form-label"> <span class="text-danger">*</span> Forma de Pago:</label>
                                                <select class="form-select mb-3 shadow-none" name="forma" required>
                                                    <option value="" selected disabled>Selecciona Forma de Pago</option>
                                                    @foreach ($formaPagos as $met)
                                                        <option value="{{ $met->id }}" {{ $isEditing && $pago->forma_id == $met->id ? 'selected' : '' }}>
                                                            {{ $met->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('forma')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="form-label"><span class="text-danger">*</span>
                                                    Estudiante:</label>
                                                <select id="estudiante" class="form-select" name="estudiante" {{ $isEditing ? '' : 'required' }}></select>
                                                @if ($isEditing)
                                                <small class="text-warning">Estudiante: <strong>{{ $estudiante }}</strong></small>
                                                @endif
                                                @error('estudiante')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            @if (!$isEditing)
                                                <div class="form-group col-lg-3">
                                                    <label class="form-label"><span class="text-danger">*</span>
                                                        Fecha:</label>
                                                    <input type="date" class="form-control" name="fecha"
                                                        value="{{ $fecha }}" required>
                                                    @error('fecha')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            @endif
                                            <div class="form-group {{ $isEditing ? 'col-lg-6' : 'col-lg-3'}}">
                                                <label class="form-label"><span class="text-danger">*</span> Monto:</label>
                                                @foreach ($metodo as $met)
                                                    <div class="form-check">
                                                        @if ($isEditing)
                                                            @php
                                                                $montoPagado = $pagoMensual->where('metodo_id', $met->id)->isNotEmpty();
                                                            @endphp
                                                        @endif
                                                        <input class="form-check-input" type="checkbox" name="monto[]" id="monto{{ $met->id }}" value="{{ $met->id }}"
                                                            @if ($isEditing)
                                                                {{ $montoPagado ? 'checked' : '' }}
                                                            @endif>
                                                        <label class="form-check-label" for="monto{{ $met->id }}">{{ $met->nombre }} - {{ $met->monto }}</label>
                                                    </div>
                                                @endforeach
                                                @error('monto')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="form-label">Descripción: (Opcional) </label>
                                                <textarea type="text" class="form-control" name="descripcion"
                                                    placeholder="Escribe una breve descripción">{{ $isEditing ? $pago->comentario : '' }}</textarea>
                                                @error('descripcion')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-secondary"
                                        onclick="window.history.back()">Cancelar</button>
                                    <div class="btn-group">
                                        <button class="btn btn-danger" type="submit">Guardar</button>
                                        <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="visually-hidden">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="">Guardar e Imprimir</a></li>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script src="{{ asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $("#estudiante").select2({
            placeholder: 'Escriba el nombre',
            allowClear: true,
            ajax: {
                url: "{{ route('search.estudiantes') }}",
                type: "post",
                delay: 250,
                dataType: 'json',
                data: function(params) {
                    return {
                        name: params.term,
                        "_token": "{{ csrf_token() }}",
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.persona.nombre + ' ' + item.persona.ap_paterno + ' ' + item.persona.ap_materno
                            }
                        })
                    };
                },
            },
        });
    });
</script>
@endsection
@endsection