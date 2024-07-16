@extends('layouts.app')

@section('content')
<div class="position-relative iq-banner">
    <div class="iq-navbar-header" style="height: 215px;">
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
    <div class="card">
        <div class="card-body">
            <div class="header-title text-center">
                <p class="h4">Agregar Nuevo Criterio</p>
                @if ($ponderacion == 0)
                <small class="text-danger">No se pueden registra mas criterios la ponderacion llego a 0</small>
                @endif
            </div>
            <hr>
            @if ($ponderacion != 0)
            <form class="needs-validation" novalidate method="POST" action="{{ route('admin.store.criterios') }}">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-8">
                        <input type="text" class="form-control" name="nombre" placeholder="Ingresa un nombre">
                        @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-lg-2">
                        <input type="text" class="form-control" name="porcentaje" id="porcentajeCrit" placeholder="%"
                            oninput="restarPorcentaje()" pattern="\d*" required>
                        @error('porcentaje')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-2">
                        <input type="numeric" class="form-control" name="ponderacion" id="ponderacion"
                            value="{{ $ponderacion }}" disabled>
                        <input type="hidden" name="ponderacion_hidden" id="ponderacion_hiddenCriterio">
                    </div>
                </div>
                <div id="alert" class="text-danger"></div>
                <div class="text-center">
                    <button type="reset" class="btn btn-danger btn-sm">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm"
                        onclick="enablePonderacionCrit()">Guardar</button>
                </div>
            </form>
            @endif
            <hr>
            <div class="header-title">
                <h4 class="card-title">Criterios de Evaluación</h4>
                <small>El criterio que tenga el <i class="bi bi-check"></i> tiene habilitado para tomar en cuenta la asistencia</small>
            </div>
            <hr>
            <div class="list-group">
                @forelse ($criterios as $criterio)
                <div class="list-group-item list-group-item">
                    <div class=" d-flex justify-content-between align-items-center py-2">
                        <div>
                            {{ $criterio->nombre }}
                            <a class="btn-sm text-secondary" title="Editar"
                                href="{{ route('admin.editar.criterios', $criterio->id) }}">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a class="btn-sm text-danger" title="Borrar" href="#" data-bs-placement="top"
                                data-bs-toggle="modal" data-bs-target="#deleteCritConfirm{{ $criterio->id }}">
                                <i class="bi bi-trash"></i>
                            </a>
                            <a class="btn-sm text-warning" title="Registra Categoria" href="#"
                                onclick="toggleForm('{{ $criterio->id }}')">
                                <i class="bi bi-plus-circle"></i>
                            </a>
                        </div>
                        <span class="badge text-black">{{ $criterio->porcentaje }} %</span>
                    </div>
                    <!-- Formulario de registro de categoría, oculto por defecto -->
                    <div id="formCategoria{{ $criterio->id }}" class="form-categoria" style="display: none;">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('admin.store.cat.criterios') }}">
                            @csrf
                            <input type="hidden" name="criterio" value="{{ $criterio->id }}" required>
                                <div class="row">
                                    <div class="form-group col-lg-8">
                                        <input type="text" class="form-control form-control-sm" name="nombre"
                                            placeholder="Ingrese un nombre" required>
                                        @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <input type="text" class="form-control form-control-sm" name="porcentajeCat"
                                            id="porcentajeCat{{ $criterio->id }}" placeholder="%"
                                            oninput="restarPorcentajeCat('{{ $criterio->id }}')" pattern="\d*" required>
                                        @error('porcentajeCat') <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <input type="text" class="form-control form-control-sm"
                                            value="{{ $criterio->total }}" name="totalPocentCategoria"
                                            id="totalPocentCategoria{{ $criterio->id }}" required disabled>
                                        @error('totalPocentCategoria') <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <div class="form-check">
                                            <input class="form-check-input" name="asistencia" type="checkbox" id="disabledFieldsetCheck">
                                            <label class="form-check-label" for="disabledFieldsetCheck"> Incluir las asistencias a la nota</label>
                                        </div>
                                        @error('asistencia') <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div id="alertCat{{ $criterio->id }}" class="text-danger"></div>
                            <div class="text-center">
                                <button type="reset" class="btn btn-sm btn-secondary"
                                    onclick="cerrartoggleForm('{{ $criterio->id }}')">Cancelar</button>
                                <button type="submit" class="btn btn-sm btn-primary"
                                    onclick="enablePonderacion('{{ $criterio->id }}')">Guardar</button>
                            </div>
                        </form>
                    </div>

                    @include('admin.cursos.criterios.modal_confirm', ['modalId' => $criterio->id, 'id' =>
                    $criterio->id])
                    @if ($criterio->categorias->isNotEmpty())
                    @foreach ($criterio->categorias as $categoria)
                    <div class="list-group-item rounded-2 py-2">
                        <div class="d-flex justify-content-between align-items-center px-1">
                            <div>
                                {{ $categoria->nombre }}
                                <a class="btn-sm text-primary"
                                    href="{{ route('admin.editar.cat.criterios', $categoria->id) }}" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a class="btn-sm text-danger" href="#" title="Borrar" data-bs-placement="top"
                                    data-bs-toggle="modal" data-bs-target="#deleteCritConfirmCat{{ $categoria->id }}">
                                    <i class="bi bi-trash"></i>
                                </a>
                                @if ($categoria->asistencia)
                                    <button class="btn btn-sm btn-link text-success"><i class="bi bi-check"></i></button>
                                @endif
                            </div>
                            @include('admin.cursos.criterios.modal_confirm', ['modalId' => $categoria->id, 'id' =>
                            $categoria->id])
                            <span class="badge text-black">{{ $categoria->porcentaje }} %</span>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                @empty
                <div class="text-center">
                    <p>No hay criterios</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    var ponderacionOriginal = parseFloat(document.getElementById('ponderacion').value) || 0;
    
    function restarPorcentaje() {
        var porcentaje = parseFloat(document.getElementById('porcentajeCrit').value) || 0;
        var ponderacion = ponderacionOriginal; // Usar el valor original de la ponderación
        var resultado = ponderacion - porcentaje;
        if (resultado >= 0) {
            document.getElementById('ponderacion').value = resultado;
            clearErrorCrit(); // Llamar a la función para limpiar el mensaje de error
        } else {
            document.getElementById('porcentajeCrit').value = '';
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
        document.getElementById('ponderacion').disabled = false;
        document.getElementById('ponderacion_hiddenCriterio').value = document.getElementById('ponderacion').value;
    }
</script>


<script>
    var totalCatPonderacion = 0;
    function toggleForm(id) {
        // Cerrar todos los formularios
        var forms = document.querySelectorAll('.form-categoria');
        forms.forEach(function(form) {
        form.style.display = 'none';
        });

        // Abrir el formulario seleccionado
        var form = document.getElementById('formCategoria' + id);
        form.style.display = 'block';
        totalCatPonderacion = parseFloat(document.getElementById('totalPocentCategoria' + id).value) || 0;
    }

    function cerrartoggleForm(id) {
        // Cerrar todos los formularios
        var forms = document.querySelectorAll('.form-categoria');
        forms.forEach(function(form) {
        form.style.display = 'none';
        });
    }
  
    function restarPorcentajeCat(id) {
      var ponderacion = totalCatPonderacion;
      var porcentaje = parseFloat(document.getElementById('porcentajeCat' + id).value) || 0;
      var resultado = ponderacion - porcentaje;
  
      if (resultado >= 0) {
        document.getElementById('totalPocentCategoria' + id).value = resultado;
        clearError(id); // Limpiar cualquier mensaje de error
      } else {
        document.getElementById('porcentajeCat' + id).value = '';
        var error = "El porcentaje no puede ser mayor que la ponderación.";
        showError(id, error); // Mostrar el mensaje de error
      }
    }
  
    function showError(id, errorMessage) {
      document.getElementById('alertCat' + id).innerText = errorMessage;
      document.getElementById('alertCat' + id).style.display = 'block';
    }
    
    function clearError(id) {
      document.getElementById('alertCat' + id).innerText = '';
      document.getElementById('alertCat' + id).style.display = 'none';
    }
  
    function enablePonderacion(id) {
      document.getElementById('totalPocentCategoria' + id).disabled = false;
    }
</script>



@endsection