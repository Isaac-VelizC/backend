<div>
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
                <img src="{{ asset('img/portada.jpg') }}" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
            </div>
        </div>
    </div>
    <div class="conatiner-fluid content-inner mt-n5 py-0">
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
                                                    <input class="form-check-input" type="checkbox" 
                                                        @if(in_array($item->id, $materiasSeleccionadas)) 
                                                            wire:click="BorrarEvaluacion({{ $item->id }})" checked 
                                                        @else 
                                                            wire:click="habilitarEvaluacion({{ $item->id }})" 
                                                        @endif
                                                    >
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
</div>
