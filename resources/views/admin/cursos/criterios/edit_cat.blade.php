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
        <div class="iq-header-img">
            <img src="{{ asset('img/fondo1.jpg') }}" alt="header" class="img-fluid w-100 h-100 animated-scaleX">
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
                        <h4 class="card-title">Actualizar información de la categoria</h4>
                    </div>
                    <form class="needs-validation" novalidate method="POST" action="{{ route('admin.update.cat.criterios', $categoria->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <select class="form-select" name="criterio" required onchange="selectPonderacionEdit(this.value)">
                                    <option value="" disabled>Seleccionar un criterio</option>
                                    @foreach ($criterios as $crit)
                                        <option value="{{ $crit->id }}" {{ $crit->id == $categoria->criterio_id ? 'selected' : '' }}>{{ $crit->nombre }}</option>
                                    @endforeach
                                </select>                            
                                @error('criterio') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-lg-8">
                                <input type="text" class="form-control" name="nombre" value="{{ $categoria->nombre }}" placeholder="Ingrese un nombre">
                                @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-lg-2">
                                <input type="hidden" name="" value="{{ $categoria->porcentaje }}" id="porcentajeDefecto">
                                <input type="text" class="form-control" name="porcentajeCat" id="porcentajeEditCat" value="{{ $categoria->porcentaje }}" placeholder="%" oninput="restarPorcentajeEditCat()" pattern="\d*" required>
                                @error('porcentajeCat') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-lg-2">
                                <input type="numeric" class="form-control" name="totalPocentCategoria" id="totalPocentCategoriaEdit" value="{{ $categoria->criterio->total + $categoria->porcentaje }}" required>
                                @error('totalPocentCategoria') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div id="alertCat" class="text-danger"></div>
                        <div class="text-center">
                            <a href="{{ route('admin.tareas.criterios') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary" onclick="enablePonderacion()">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var ponderacion = parseFloat(document.getElementById('totalPocentCategoriaEdit').value);
    var defecto = parseFloat(document.getElementById('porcentajeDefecto').value);

    function selectPonderacionEdit(id) {
        axios.get('/select/ponderacion/' + id)
            .then(function (response) {
                ponderacion = response.data.data + defecto;
                document.getElementById('totalPocentCategoriaEdit').value = response.data.data + defecto;
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    // Función para restar el porcentaje
    function restarPorcentajeEditCat() {
        var porcentaje = parseFloat(document.getElementById('porcentajeEditCat').value) || 0;
        var resultado = ponderacion - porcentaje;
        if (resultado >= 0) {
            document.getElementById('totalPocentCategoriaEdit').value = resultado;
            clearError(); // Limpiar cualquier mensaje de error
        } else {
            document.getElementById('porcentajeEditCat').value = '';
            var error = "El porcentaje no puede ser mayor que la ponderación.";
            showError(error); // Mostrar el mensaje de error
        }
    }

    // Funciones para mostrar y limpiar mensajes de error
    function showError(errorMessage) {
        document.getElementById('alertCat').innerText = errorMessage;
        document.getElementById('alertCat').style.display = 'block';
    }
    
    function clearError() {
        document.getElementById('alertCat').innerText = '';
        document.getElementById('alertCat').style.display = 'none';
    }

    // Función para habilitar el campo totalPocentCategoriaEdit
    function enablePonderacion() {
        document.getElementById('totalPocentCategoriaEdit').disabled = false;
        document.getElementById('ponderacion_hidden').value = document.getElementById('totalPocentCategoriaEdit').value;
    }
</script>

@endsection
