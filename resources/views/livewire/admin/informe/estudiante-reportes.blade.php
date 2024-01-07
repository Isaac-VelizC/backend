<div>
    <div class="iq-navbar-header" style="height: 170px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                        <div>
                            <h1>Reporte de Estudiantes</h1>
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
                                                <select wire:model='semestre' class="form-select">
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
                                                        <td>Semestre</td>
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
