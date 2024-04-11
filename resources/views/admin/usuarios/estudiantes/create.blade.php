@extends('layouts.app')

@section('content')

<div class="position-relative iq-banner">
    <div class="iq-navbar-header" style="height: 150px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                        <div>
                            <h5>{{ Breadcrumbs::render('Estudiantes.create') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="iq-header-img">
            <img src="{{ asset('img/fondo3.jpg') }}" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
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
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Información del Estudiante</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('admin.inscripcion.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="form-label" for="fname">Nombres: *</label>
                                        <input type="text" class="form-control" id="fname" name="nombre" value="{{ old('nombre') }}" required>
                                    </div>
                                    @error('nombre')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label class="form-label" for="lname">Primer Apellido:</label>
                                        <input type="text" class="form-control" id="lname" name="ap_pat" value="{{ old('ap_pat') }}">
                                    </div>
                                    @error('ap_pat')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label class="form-label" for="lname">Segundo Apellido:</label>
                                        <input type="text" class="form-control" id="lname" name="ap_mat" value="{{ old('ap_mat') }}">
                                    </div>
                                    @error('ap_mat')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label class="form-label" for="cname">Cedula: *</label>
                                        <input type="text" class="form-control" id="cname" name="ci" value="{{ old('ci') }}" required>
                                    </div>
                                    @error('ci')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label class="form-label" for="cname">Fecha Nacimiento: *</label>
                                        <input type="date" class="form-control" id="cname" name="fNac" value="{{ old('fNac') }}" required>
                                    </div>
                                    @error('fNac')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group col-sm-4">
                                        <label class="form-label">Genero: *</label>
                                        <select name="genero" class="selectpicker form-select" data-style="py-0" value="{{ old('genero') }}" required>
                                            <option value="" disabled selected>Seleccionar</option>
                                            <option value="Hombre">Hombre</option>
                                            <option value="Mujer">Mujer</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>
                                    @error('genero')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group col-md-3">
                                        <label class="form-label" for="add1">Dirección: *</label>
                                        <input type="text" class="form-control" id="add1" name="direccion" value="{{ old('direccion') }}" required>
                                    </div>
                                    @error('direccion')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group col-md-3">
                                        <label class="form-label">Horario: *</label>
                                        <select class="selectpicker form-select" data-style="py-0" name="horario" required>
                                            <option value="" disabled selected>Seleccionar</option>
                                            @if ($horarios->count() > 0)
                                                @foreach ($horarios as $mod)
                                                    <option value="{{ $mod->id }}">{{ $mod->turno }}</option>
                                                @endforeach
                                            @else
                                                <option value="">No Hay Horarios</option>
                                            @endif
                                        </select>
                                    </div>
                                    @error('horario')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group col-md-3">
                                        <label class="form-label" for="mobno">Numero Celular: *</label>
                                        <input type="text" class="form-control" id="mobno" name="telefono" value="{{ old('telefono') }}" required>
                                    </div>
                                    @error('telefono')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group col-md-3">
                                        <label class="form-label" for="email">E mail: *</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                    </div>
                                    @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="text-center">
                                <button id="mostrarBtn" class="btn btn-link" type="button">¿Agregar contacto?</button>
                                <button id="ocultarBtn" class="btn btn-link" type="button" style="display: none;">Ocultar</button>
                            </div>
                            <div id="infoContacto" class="col-sm-12 col-lg-12" style="display: none;">
                                <h5 class="mb-3">Información de Contacto (Opcional)</h5>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="form-label" for="nomb">Nombre: *</label>
                                        <input type="text" class="form-control" id="nomb" name="nombreC" value="{{ old('nombreC') }}">
                                    </div>
                                    @error('nombreC')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label class="form-label" for="apePC">Primer Apellido:</label>
                                        <input type="text" class="form-control" id="apPC" name="ap_patC" value="{{ old('ap_patC') }}">
                                    </div>
                                    @error('ap_patC')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label class="form-label" for="apeMC">Segundo Apellido:</label>
                                        <input type="text" class="form-control" id="apMC" name="ap_matC" value="{{ old('ap_matC') }}">
                                    </div>
                                    @error('ap_matC')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group col-md-3">
                                        <label class="form-label" for="ciC">Cedula: *</label>
                                        <input type="text" class="form-control" id="ciC" name="ciC" value="{{ old('ciC') }}">
                                    </div>
                                    @error('ciC')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group col-md-3">
                                        <label class="form-label" for="numcelC">Numero de Celular: *</label>
                                        <input type="text" class="form-control" id="numcelC" name="telefonoC" value="{{ old('telefonoC') }}">
                                    </div>
                                    @error('telefonoC')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group col-sm-3">
                                        <label class="form-label">Genero: *</label>
                                        <select name="generoC" class="selectpicker form-select" value="{{ old('generoC') }}" data-style="py-0">
                                            <option value="Hombre" selected>Hombre</option>
                                            <option value="Mujer">Mujer</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>
                                    @error('generoC')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group col-md-3">
                                        <label class="form-label" for="emailC">Correo Electronico:</label>
                                        <input type="text" class="form-control" id="emailC" name="emailC" value="{{ old('emailC') }}">
                                    </div>
                                    @error('emailC')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Inscribir Estudiante</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mostrarBtn = document.getElementById('mostrarBtn');
        const ocultarBtn = document.getElementById('ocultarBtn');
        const infoContacto = document.getElementById('infoContacto');

        mostrarBtn.addEventListener('click', function() {
            infoContacto.style.display = 'block';
            ocultarBtn.style.display = 'inline';
            mostrarBtn.style.display = 'none';
        });

        ocultarBtn.addEventListener('click', function() {
            infoContacto.style.display = 'none';
            ocultarBtn.style.display = 'none';
            mostrarBtn.style.display = 'inline';
            // Restablecer valores de los campos de entrada
            const camposEntrada = infoContacto.querySelectorAll('input[type="text"]');
            camposEntrada.forEach(function(input) {
                input.value = ''; // Restablecer valor a vacío
            });
        });
    });
</script>
@endsection
