@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 215px;">
  <div class="container-fluid iq-container">
      <div class="row">
          <div class="col-md-12">
              <div class="flex-wrap d-flex justify-content-between align-items-center">
                  <div>
                     <h1 style="color: black">Estudiante {{$estudiante->nombre}} {{$estudiante->ap_paterno}} {{$estudiante->ap_materno}}</h1>
                  </div>
              </div>
          </div>
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
    <div>
       <div class="row">
          <div class="col-xl-3 col-lg-4">
             <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <div class="user-profile">
                           @if ($estudiante->photo != 'user.jpg')
                              <img src="{{ asset($estudiante->photo) }}" alt="profile-img" class="rounded-pill avatar-130 img-fluid">
                           @else
                              <img src="{{ asset('img/user.jpg') }}" alt="profile-img" class="rounded-pill avatar-130 img-fluid">
                           @endif
                        </div>
                        <p class="d-inline-block pl-3"> {{ $estudiante->user->getRoleNames()->first() }}</p>
                     </div>
                   @livewire('admin.estudiante-password', ['id' => $estudiante->id])
                </div>
             </div>
          </div>
          <div class="col-xl-9 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="bd-example">
                        <ul class="nav nav-pills" data-toggle="slider-tab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#pills-home1" type="button" role="tab" aria-controls="home" aria-selected="true">Estudiante</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#pills-profile1" type="button" role="tab" aria-controls="profile" aria-selected="false">Contacto</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#pills-contact1" type="button" role="tab" aria-controls="contact" aria-selected="false">Materias</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home1" role="tabpanel" aria-labelledby="pills-home-tab1">
                                @include('admin.usuarios.estudiantes.components.info_estud')
                            </div>
                            <div class="tab-pane fade" id="pills-profile1" role="tabpanel" aria-labelledby="pills-profile-tab1">
                                @livewire('admin.estudiante-contacto', ['estudiante' => $estudiante->estudiante->id])
                            </div>
                            <div class="tab-pane fade" id="pills-contact1" role="tabpanel" aria-labelledby="pills-contact-tab1">
                                <div class="card-body">
                                    <div class="new-user-info">
                                            <div class="row">
                                                @if ($materias->count() > 0)
                                                    @foreach ($materias as $item)
                                                        <div class="col-lg-4 col-md-12">
                                                            <a type="button" data-bs-toggle="modal" data-bs-target="#cursoModal" onclick="loadCursoData({{ $item->curso->id}}, {{$est->id}})">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="d-grid grid-flow-col align-items-center justify-content-between mb-2">
                                                                            <div class="d-flex align-items-center">
                                                                                <p class="mb-0 h6" style="color: black;">{{ $item->curso->nombre }}</p>
                                                                            </div>
                                                                            <div class="dropdown">
                                                                                <p class="h6"><span class="badge bg-light text-dark">0</span></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <p class="text-center">No hay materias</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @include('admin.usuarios.estudiantes.components.cursos_programar')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
       </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const formulario = document.getElementById('formHabilitarDesabilitar');
        const editarBtn = document.getElementById('editarBtn');
        const guardarBtn = document.getElementById('guardarBtn');
        const cancelarBtn = document.getElementById('cancelarBtn');
        const generoSelect = document.getElementById('generoSelect');
        const campos = formulario.querySelectorAll('input');
        const valoresOriginales = {};
        campos.forEach(function (campo) {
            valoresOriginales[campo.name] = campo.value;
        });
        valoresOriginales['generoSelect'] = generoSelect.value;
        function restaurarValoresOriginales() {
            campos.forEach(function (campo) {
                campo.value = valoresOriginales[campo.name];
            });
            generoSelect.value = valoresOriginales['generoSelect'];
        }
        // Función para habilitar o deshabilitar todos los campos y el select
        function habilitarDesabilitarCampos(habilitar) {
            campos.forEach(function (campo) {
                campo.disabled = !habilitar;
            });
            generoSelect.disabled = !habilitar;
            editarBtn.style.display = habilitar ? 'none' : 'block';
            guardarBtn.style.display = habilitar ? 'block' : 'none';
            cancelarBtn.style.display = habilitar ? 'block' : 'none';
        }
        // Manejar eventos de clic
        editarBtn.addEventListener('click', function () {
            habilitarDesabilitarCampos(true); // Habilitar
        });
        cancelarBtn.addEventListener('click', function () {
            restaurarValoresOriginales();
            habilitarDesabilitarCampos(false);
        });
        habilitarDesabilitarCampos(false);
    });
</script>
@endsection