@extends('layouts.app')

@section('content')
<div class="position-relative iq-banner">
    <div class="iq-navbar-header" style="height: 200px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                        <h5>{{ Breadcrumbs::render('listado.evaluacion') }}</h5>
                        <div>
                            <a class="btn btn-outline-info" href="{{ route('historial.evaluacion.docente') }}">
                                <i class="bi bi-clock-history"></i>
                                <span class="item-name">Historial</span>
                            </a>
                            <a class="btn btn-outline-light" href="{{ route('evaluacion.docente') }}">
                                <i class="bi bi-question"></i>
                                <span class="item-name">Gestionar Preguntas</span>
                            </a>
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
    <div id="alerts"></div>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                               <h4 class="card-title">Listado de Materias Habilitadas</h4>
                            </div>
                         </div>
                         <div class="card-body">
                            <div class="table-responsive">
                                <div class="text-center">
                                    <button id="seleccionarTodo" class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" title="hola"><i class="bi bi-check-all"></i></button>
                                    <button id="deseleccionarTodo" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-circle"></i></button>
                                    <button id="enviarDatos" class="btn btn-sm btn-outline-primary"><i class="bi bi-send"></i></button>
                                    <button id="quitarDatos" class="btn btn-sm btn-outline-warning"><i class="bi bi-trash"></i></button>
                                </div>
                               <table id="datatable" class="table table-striped" data-toggle="data-table">
                                  <thead>
                                     <tr>
                                        <th></th>
                                        <th>Nombre</th>
                                        <th>Horario</th>
                                        <th>Modalidad</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                     </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($materias as $item)
                                        <tr>
                                            <td class="text-center">
                                                <input class="form-check-input seleccionar" type="checkbox" name="materia[]" value="{{ $item->id }}" {{ $item->evaluacionDocente ? 'checked' : '' }}>
                                            </td>                                               
                                            <td>
                                                <a href="{{ route('admin.cursos.show', [$item->id]) }}">{{ $item->curso->nombre }}</a>
                                            </td>
                                            <td>{{ $item->horario->turno }}</td>
                                            <td>{{ $item->curso->semestre->nombre }}</td>
                                            <td>{{ $item->fecha_ini }}</td>
                                            <td>{{ $item->fecha_fin }}</td>
                                        </tr>
                                    @endforeach
                                  </tbody>
                               </table>
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Manejar la selección de todos los checkboxes
    document.getElementById('seleccionarTodo').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('.seleccionar');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = true;
        });
    });

    // Manejar la deselección de todos los checkboxes
    document.getElementById('deseleccionarTodo').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('.seleccionar');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
    });

    // Enviar datos para habilitar evaluaciones
    document.getElementById('enviarDatos').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('.seleccionar:checked');
        var datosSeleccionados = [];
        checkboxes.forEach(function(checkbox) {
            datosSeleccionados.push(checkbox.value);
        });
        // Enviar datos utilizando Axios
        axios.post('/evaluacion/habilitar/docente', {
            materias: datosSeleccionados,
        })
        .then(function (response) {
            if (response.data.success) {
                document.getElementById('alerts').innerHTML = '<div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert"><span>' + response.data.success + '</span><button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            } else {
                document.getElementById('alerts').innerHTML = '<div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert"><span>' + response.data.error + '</span><button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
        })
        .catch(function (error) {
            // Manejar errores
            console.error(response.data.error);
        });
    });

    // Enviar datos para deshabilitar evaluaciones
    document.getElementById('quitarDatos').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('.seleccionar:not(:checked)');
        var datosSeleccionados = [];
        checkboxes.forEach(function(checkbox) {
            datosSeleccionados.push(checkbox.value);
        });
        // Enviar datos utilizando Axios
        axios.post('/evaluacion/deshabilitar/docente', {
            materias: datosSeleccionados,
        })
        .then(function (response) {
            console.log(response.data.success);
            if (response.data.success) {
                document.getElementById('alerts').innerHTML = '<div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert"><span>' + response.data.success + '</span><button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            } else {
                document.getElementById('alerts').innerHTML = '<div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert"><span>' + response.data.error + '</span><button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
        })
        .catch(function (error) {
            // Manejar errores
            console.error(error);
        });
    });
</script>
@endsection
