@extends('layouts.app')

@section('content')
<div class="position-relative iq-banner">
    <div class="iq-navbar-header" style="height: 180px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                        <div>
                            <h4>{{ Breadcrumbs::render('criterios.gestion' ) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="conatiner-fluid content-inner mt-n5 py-0">
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
                    <div class="header-title">
                        <h4 class="card-title">Criterios de Evaluación</h4>
                    </div>
                    <form class="needs-validation" novalidate method="POST" action="{{ route('admin.update.criterios', $criterio->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="form-group col-lg-8">
                                <input type="text" class="form-control" name="nombre" value="{{ $criterio->nombre }}" placeholder="Ingresa un nombre">
                                @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-lg-2">
                                <input type="text" class="form-control" name="porcentaje" id="porcentajeEditCrit" value="{{ $criterio->porcentaje }}" placeholder="%" oninput="restarPorcentajeEdit()" pattern="\d*" required>
                                @error('porcentaje')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-lg-2">
                                <input type="numeric" class="form-control" name="ponderacion" id="ponderacionEdit" value="{{ $criterio->porcentaje + $ponderacion }}" readonly>
                                <input type="hidden" name="ponderacion_hidden" id="ponderacion_hiddenCriterioEdit">
                            </div>
                        </div>
                        <div id="alert" class="text-danger"></div>
                        <div class="text-center">
                            <a href="{{ route('admin.tareas.criterios') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary" onclick="enablePonderacionCrit()">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var ponderacionOriginal = parseFloat(document.getElementById('ponderacionEdit').value) || 0;
    
    function restarPorcentajeEdit() {
        var porcentaje = parseFloat(document.getElementById('porcentajeEditCrit').value) || 0;
        var ponderacion = ponderacionOriginal; // Usar el valor original de la ponderación
        var resultado = ponderacion - porcentaje;
        if (resultado >= 0) {
            document.getElementById('ponderacionEdit').value = resultado;
            clearErrorCrit(); // Llamar a la función para limpiar el mensaje de error
        } else {
            document.getElementById('porcentajeEditCrit').value = '';
            var error = "El porcentaje no puede ser mayor que la ponderación.";
            showErrorCrit(error); // Llamar a la función para mostrar el mensaje de error
        }
    }
    
    function showErrorCrit(errorMessage) {
        document.getElementById('alert').innerText = errorMessage;
        document.getElementById('alert').style.display = 'block';
    }
    
    function clearErrorCrit() {
        document.getElementById('alert').innerText = '';
        document.getElementById('alert').style.display = 'none';
    }

    function enablePonderacionCrit() {
        document.getElementById('ponderacionEdit').disabled = false;
        document.getElementById('ponderacion_hiddenCriterioEdit').value = document.getElementById('ponderacionEdit').value;
    }
</script>


@endsection
