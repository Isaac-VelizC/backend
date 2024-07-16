@extends('layouts.app')

@section('content')
<div class="position-relative iq-banner">
    <div class="iq-navbar-header" style="height: 150px;">
       <div class="container-fluid iq-container">
          <div class="row">
             <div class="col-md-12">
                <div class="flex-wrap d-flex justify-content-between align-items-center">
                   <div>
                        <h5 class="text-black">{{ Breadcrumbs::render( $isEditing ? 'Materias.edit' : 'Materias.create', $materia) }}</h5>
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
    <div class="row">                
        <div class="col-sm-12 col-lg-12">
            @if(session('error'))
                <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
                    <span>{{ session('error') }}</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="new-user-info">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                               <h4 class="card-title">{{ $materia->nombre }}</h4>
                               <p>{{ $materia->descripcion }}</p>
                               @if ($isEditing)
                               <strong>Docente :</strong> {{ $asignado->docente->persona->nombre .' '. $asignado->docente->persona->ap_paterno.' '. $asignado->docente->persona->ap_materno }}
                               <br>
                               <strong>Curso :</strong> {{ $asignado->aula->nombre }}
                               @endif
                            </div>
                            <div>
                                <a href="{{ route('admin.calendario') }}">Ir a calendario</a>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <form class="needs-validation text-black" novalidate method="POST" action="{{ $isEditing ? route('admin.asignar.actualizar-curso', $asignado->id) : route('admin.asignar.guardar.curso') }}" onsubmit="return validateForm()">
                                    @csrf
                                    @if($isEditing)
                                        @method('PUT')
                                    @endif
                                    <input type="hidden" name="curso" value="{{ $materia->id }}">
                                    <div class="row">
                                        <p class="text-warning">Seleccionar turno de horario de la materia</p>
                                        <div class="form-group col-md-12 d-flex">
                                            @if ($horarios->count() > 0)
                                                @foreach ($horarios as $item)
                                                    <div class="form-check d-block">
                                                        <label class="form-check-label" for="horario{{ $item->id }}">{{ $item->turno }}</label>
                                                        <input class="form-check-input" type="radio" name="horario" value="{{ $item->id }}" id="horario{{ $item->id }}" required {{ (old('horario', $isEditing ? $asignado->horario_id : '') == $item->id) ? 'checked' : '' }} style="margin-right: 10px; margin-left: 10px;">
                                                    </div>
                                                @endforeach
                                            @else
                                                <option value="">No hay Horarios</option>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="docenteSelect">{{ $isEditing ? 'Cambiar docente (Opcional)' : 'Docentes: *' }}</label>
                                            <select name="docente" class="form-select" id="docenteSelect" {{ $isEditing ? '' : 'required' }}>
                                                <option value="" selected disabled>
                                                    {{ $isEditing ? $asignado->docente->persona->nombre .' '. $asignado->docente->persona->ap_paterno.' '. $asignado->docente->persona->ap_materno : 'Seleccionar' }}
                                                </option>
                                            </select>
                                            @error('docente')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="aulaSelect">{{ $isEditing ? 'Aula (Opcional)' : 'Aulas: *' }}</label>
                                            <select name="aula" class="form-select" id="aulaSelect" {{ $isEditing ? '' : 'required' }}>
                                                <option value="" selected disabled>{{ $isEditing ? $asignado->aula->nombre : 'Seleccionar' }}</option>
                                            </select>
                                            @error('aula')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="cupoid">Cupos: *</label>
                                            <input type="number" class="form-control" id="cupoid" name="cupo" value="{{ old('cupo', $isEditing ? $asignado->cupo : '') }}" required min="1">
                                            @error('cupo')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="fechaIniId">Fecha Inicio: *</label>
                                            <input type="date" class="form-control" id="fechaIniId" name="fechaInicio" value="{{ old('fechaInicio', $isEditing ? $asignado->fecha_ini : '') }}" readonly required>
                                            @if($errors->has('fechaInicio'))
                                                <div class="alert alert-danger">{{ $errors->first('fechaInicio') }}</div>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="fechaFinId">Fecha Fin: *</label>
                                            <input type="date" class="form-control" id="fechaFinId" name="fechaFin" value="{{ old('fechaFin', $isEditing ? $asignado->fecha_fin : '') }}" readonly required>
                                            @if($errors->has('fechaFin'))
                                                <div class="alert alert-danger">{{ $errors->first('fechaFin') }}</div>
                                            @endif
                                        </div>
                                        <small class="text-warning">Seleccione fechas en el calendario.</small>
                                    </div>
                                    <hr>
                                    <div class="text-center">
                                        <a type="reset" class="btn btn-sm btn-danger" href="{{ route('admin.cursos') }}">Cancelar</a>
                                        <button type="submit" class="btn btn-sm btn-warning">{{ $isEditing ? 'Actualizar' : 'Habilitar' }}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <div id="calendar2" class="calendar-s"></div>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    "use strict";
    
    if (document.querySelectorAll('#calendar2').length) {
        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar2');
            let calendar2 = new FullCalendar.Calendar(calendarEl, {
                selectable: true,
                plugins: ["timeGrid", "dayGrid", "list", "interaction"],
                timeZone: "UTC",
                defaultView: "dayGridMonth", // Puedes usar "timeGridWeek" o "timeGridDay"
                locale: 'es',
                displayEventTime: false,
                contentHeight: "auto",
                eventLimit: true,
                droppable: true,
                dayMaxEvents: 4,
                header: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth"
                },
                events: baseUrl + "/calendar/inicio/fin",
    
                eventClick: function (info) {
                    axios.post(baseUrl + "/calendar/" + info.event.id + "/evento/edit")
                        .then((respuesta) => {
                            document.getElementById('fechaIniId').value = respuesta.data.start;
                            document.getElementById('fechaFinId').value = respuesta.data.end;
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }
            });
    
            calendar2.render();
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[name="horario"]').forEach(function(input) {
            input.addEventListener('change', function() {
                var selectedHorario = this.value;
    
                axios.get('/ruta/del/server/para/obtener/disponibilidad', {
                    params: {
                        horario: selectedHorario,
                    }
                })
                .then(function(response) {
                    if ('docentes' in response.data) {
                        var docenteSelect = document.getElementById('docenteSelect');
                        docenteSelect.innerHTML = '<option value="" selected disabled>Seleccionar</option>';
    
                        if (Array.isArray(response.data.docentes)) {
                            response.data.docentes.forEach(function(doc) {
                                var option = document.createElement('option');
                                option.value = doc.id;
                                option.textContent = doc.nombre + ' ' + doc.ap_paterno + ' ' + doc.ap_materno;
                                docenteSelect.appendChild(option);
                            });
                        } else {
                            console.error('Error: La propiedad "docentes" no es un array en la respuesta del servidor.');
                            document.getElementById('docenteError').style.display = 'block';
                        }
                    } else {
                        console.error('Error: La propiedad "docentes" no está presente en la respuesta del servidor.');
                        document.getElementById('docenteError').style.display = 'block';
                    }
    
                    var aulaSelect = document.getElementById('aulaSelect');
                    aulaSelect.innerHTML = '<option value="" selected disabled>Seleccionar</option>';
    
                    response.data.aulas.forEach(function(aula) {
                        var option = document.createElement('option');
                        option.value = aula.id;
                        option.textContent = aula.nombre;
                        option.setAttribute('cupo', aula.capacidad);
                        aulaSelect.appendChild(option);
                    });
                })
                .catch(function(error) {
                    console.error(error);
                    document.getElementById('docenteError').style.display = 'block';
                    document.getElementById('aulaError').style.display = 'block';
                });
            });
        });
    });
</script>
    
@endsection