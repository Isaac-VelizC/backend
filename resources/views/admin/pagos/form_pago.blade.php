@extends('layouts.app')

@section('content')
<div class="position-relative iq-banner">
    <div class="iq-navbar-header text-black" style="height: 180px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <h5>{{ $isEditing ? Breadcrumbs::render('Pagos.editar', $pago) :
                            Breadcrumbs::render('Pagos.create') }}</h5>
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
                                <form class="needs-validation text-black" novalidate
                                    action="{{ $isEditing ? route('admin.update.pago', $pago->id) : route('admin.store.pago') }}"
                                    method="POST">
                                    @csrf
                                    @if ($isEditing)
                                    @method('PUT')
                                    @endif
                                    <div class="col-sm-12 col-lg-12">
                                        <p class="text-warning">Forma de pago en efectivo</p>
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label class="form-label"><span class="text-danger">*</span>
                                                    Estudiante:</label>
                                                <select id="estudiante" class="form-select" name="estudiante" {{
                                                    $isEditing ? '' : 'required' }}></select>
                                                @if ($isEditing)
                                                <small class="text-warning">Estudiante: <strong>{{ $estudiante
                                                        }}</strong></small>
                                                @endif
                                                @error('estudiante')
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
                                            @if (!$isEditing)
                                            <div class="form-group col-lg-3">
                                                <label class="form-label"><span class="text-danger">*</span>Fecha:</label>
                                                <input type="date" class="form-control" name="fecha" value="{{ $fecha }}" max="{{ $fecha }}" required>
                                                @error('fecha')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            @endif
                                            <div class="form-group {{ $isEditing ? 'col-lg-6' : 'col-lg-3'}}">
                                                <label class="form-label"><span class="text-danger">*</span>Monto:</label>
                                                @foreach ($metodo as $met)
                                                <div class="form-check">
                                                    @if ($isEditing)
                                                    @php
                                                    $montoPagado = $pagoMensual->where('metodo_id', $met->id)->isNotEmpty();
                                                    @endphp
                                                    @endif
                                                    <input class="form-check-input" type="checkbox" name="monto[]" id="metodo_{{ $met->id }}" value="{{ $met->id }}" data-monto="{{ $met->monto }}" @if ($isEditing) {{ $montoPagado ? 'checked' : '' }} @endif>
                                                    <label class="form-check-label" for="metodo_{{ $met->id }}">{{$met->nombre }} - {{ $met->monto }}</label>
                                                </div>
                                                @endforeach
                                                <p id="total">Total: Bs. 0</p>
                                                @error('monto')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <input type="hidden" name="total" id="total_hidden" value="0.00">
                                        </div>
                                        <div class="text-center">
                                            <button id="mostrarBtn" class="btn btn-link" type="button">Agregar mas meses</button>
                                            <button id="ocultarBtn" class="btn btn-link" type="button" style="display: none;">Cerrar</button>
                                        </div>
                                        <div id="infoContacto" class="col-sm-12 col-lg-12" style="display: none;">
                                            <h5 class="mb-3">Seleccionar meses de pago, año {{ $anio }}</h5>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    @foreach ($meses as $key => $mes)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="meses[]" value="{{ $key }}" {{ $isEditing ? (in_array($key, $meshoy) ? 'checked' : '') : ($key == $meshoy ? 'checked' : '') }}>
                                                        <label class="form-check-label">{{ $mes }}</label>
                                                    </div>
                                                    @endforeach
                                                    <br>
                                                    @error('meses*') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="flex-wrap d-flex justify-content-center gap-2 align-items-center">
                                        <button type="button" class="btn btn-sm btn-secondary" onclick="window.history.back()">Cancelar</button>
                                        <button type="submit" class="btn btn-sm btn-primary" onclick="window.history.back()">Registrar</button>
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
            placeholder: 'Escriba el nombre o nit/ci',
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
                                text: item.persona.nombre + ' ' + item.persona.ap_paterno + ' ' + item.persona.ap_materno + ' -- ' + item.persona.ci
                            }
                        })
                    };
                },
            },
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let total = 0;

        const updateTotal = () => {
            let checkboxes = document.querySelectorAll('input[name="monto[]"]');
            let selectedMonths = document.querySelectorAll('input[name="meses[]"]:checked').length;

            total = 0;
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    total += parseFloat(checkbox.getAttribute('data-monto'));
                }
            });

            total *= selectedMonths;
            document.getElementById('total').innerHTML = `Total: Bs.${total.toFixed(2)}`;
            document.getElementById('total_hidden').value = total.toFixed(2); // Actualizar el campo oculto
        };

        let monthCheckboxes = document.querySelectorAll('input[name="meses[]"]');
        monthCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', updateTotal);
        });

        let montoCheckboxes = document.querySelectorAll('input[name="monto[]"]');
        montoCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', updateTotal);
        });

        updateTotal();
    });
</script>
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
@endsection