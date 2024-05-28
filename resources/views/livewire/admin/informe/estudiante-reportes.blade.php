<div>
    <div class="iq-navbar-header" style="height: 170px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                        <div>
                            <h5>{{ Breadcrumbs::render('reportes.estudiantes') }}</h5>
                        </div>
                    </div>
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
                                            <h4 class="card-title mb-0">REPORTES DE ESTUDIANTES</h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <form class="form" wire:submit.prevent='searchEstudiantes'>
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <select wire:model='horario' class="form-select">
                                                    <option value="" selected>Seleccionar Horario</option>
                                                    @foreach ($horarios as $hora)
                                                        <option value="{{ $hora->id }}">{{ $hora->turno }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select wire:model='semestreId' class="form-select">
                                                    <option value="" selected>Seleccionar Semestre</option>
                                                    @foreach ($semestres as $semestre)
                                                        <option value="{{ $semestre->id }}">{{ $semestre->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select wire:model='estado' class="form-select">
                                                    <option value="" selected>Seleccionar Estado</option>
                                                    <option value="1" selected>Activo</option>
                                                    <option value="0" selected>Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm" wire:click='resetForm'>Cancelar</button>
                                                <button type="submit" class="btn btn-secondary btn-sm">Buscar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="flex-wrap d-flex justify-content-between align-items-center">
                                    <h3><b>Resultados</b></h3>
                                    <!--@if ($resultados && count($resultados) > 0)
                                        @if ($semestreId)
                                            <button class="btn btn-link text-black"  data-bs-toggle="modal" data-bs-target="#confirProgramacion">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                    <path d="M9 19h-4v-2h4v2zm2.946-4.036l3.107 3.105-4.112.931 1.005-4.036zm12.054-5.839l-7.898 7.996-3.202-3.202 7.898-7.995 3.202 3.201zm-6 
                                                    8.92v3.955h-16v-20h7.362c4.156 0 2.638 6 2.638 6s2.313-.635 4.067-.133l1.952-1.976c-2.214-2.807-5.762-5.891-7.83-5.891h-10.189v24h20v-7.98l-2 2.025z"/>
                                                </svg> Programar Materia
                                            </button>
                                        @endif
                                    @endif-->
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped" data-toggle="data-table">
                                        <thead>
                                            <tr>
                                                <th>Estudiante</th>
                                                <th>CI</th>
                                                <th>E-mail</th>
                                                <th>Turno</th>
                                                <th>Semestre</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($resultados && count($resultados) > 0)
                                                @foreach ($resultados as $item)
                                                    <tr>
                                                        <td>{{ $item->persona->nombre }} {{ $item->persona->ap_paterno }} {{ $item->persona->ap_materno }}</td>
                                                        <td>{{ $item->persona->ci }}</td>
                                                        <td>{{ $item->persona->email }}</td>
                                                        <td>{{ $item->turnos->turno }}</td>
                                                        <td>@if ($item->graduado == 0)
                                                            Primer Semestre
                                                        @endif</td>
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
    <div class="modal fade" id="confirProgramacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Programar Materia a los Estudiantes Seleccionados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" novalidate method="POST" action="">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <p>La cantidad actual es de</p>
                                <div class="form-group">
                                    <label class="form-label"><span class="text-danger">*</span> Cantidad:</label>
                                    <input type="number" class="form-control" name="cantidad" required>
                                    @error('cantidad')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
