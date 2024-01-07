<div>
    <div class="iq-navbar-header" style="height: 170px;">
        <div class="container-fluid iq-container text-black">
            <div class="row">
                <div class="col-md-12">
                    <h5>{{ Breadcrumbs::render('reportes.meterias') }}</h5>
                </div>
            </div>
        </div>
    </div>
     <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-md-12">
                <div class="row row-cols-1">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="row no-gutters">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="text-center">
                                            <h4 class="card-title mb-0">REPORTES DE MATERIAS</h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <form class="form" wire:submit.prevent='resultMateriasReport'>
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <select type="text" class="form-select" wire:model="curso">
                                                    <option value="" selected>Seleccionar Curso</option>
                                                    @foreach ($materias as $materia)
                                                        <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select wire:model="docente" class="form-select">
                                                    <option value="" selected>Seleccionar Docente</option>
                                                    @foreach ($docentes as $docente)
                                                        <option value="{{ $docente->id }}">{{ $docente->persona->nombre }} {{ $docente->persona->ap_paterno }} {{ $docente->persona->ap_materno }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <input type="date" class="form-control" wire:model="fecha" placeholder="Fecha">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col">
                                                <select type="text" class="form-select" wire:model="horario">
                                                    <option value="" selected>Seleccionar Horario</option>
                                                    @foreach ($horarios as $hora)
                                                        <option value="{{ $hora->id }}">{{ $hora->turno }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select type="text" class="form-select" wire:model="aula">
                                                    <option value="" selected>Seleccionar Aula</option>
                                                    @foreach ($aulas as $aula)
                                                        <option value="{{ $aula->id }}">{{$aula->nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select type="text" class="form-select" wire:model="estado">
                                                    <option value="" selected>Estado del curso</option>
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm" wire:click='resetForm'>Cancelar</button>
                                                <button type="submit" class="btn btn-secondary btn-sm">Enviar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="flex-wrap d-flex justify-content-between align-items-center">
                                    <p>Resultados</p>
                                    <button id="exportBtnReportMaterias" class="btn btn-link text-black">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path d="M17 13v-13h-2v5h-2v-3h-2v7h-2v-9h-2v13h-6l11 11 11-11z"/>
                                        </svg> Descargar
                                    </button>
                                </div>
                                <div class="table-responsive">
                                   <table id="datatableReportMateria" class="table table-striped" data-toggle="data-table">
                                      <thead>
                                         <tr>
                                            <th>Nombre</th>
                                            <th>Docente</th>
                                            <th>Aula</th>
                                            <th>Modalidad</th>
                                            <th>Horario</th>
                                         </tr>
                                      </thead>
                                      <tbody>
                                        @if ($resultados && count($resultados) > 0)
                                            @foreach ($resultados as $item)
                                                <tr>
                                                    <td>{{ $item->curso->nombre }}</td>
                                                    <td>{{ $item->docente->persona->nombre }} {{ $item->docente->persona->ap_paterno }} {{ $item->docente->persona->ap_materno }}</td>
                                                    <td>{{ $item->aula->nombre }}</td>
                                                    <td>{{ $item->curso->semestre->nombre }}</td>
                                                    <td>{{ $item->horario->turno }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
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