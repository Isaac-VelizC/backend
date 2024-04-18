<div>
    <div class="iq-navbar-header" style="height: 170px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                        <div>
                            <h1>Reporte de Pagos</h1>
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
                                            <h4 class="card-title mb-0">REPORTES DE PAGOS</h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <form class="form" wire:submit.prevent='searchPagos'>
                                        <div class="row">
                                            <div class="col">
                                                <select wire:model='selectEstudiante' class="form-select">
                                                    <option value="" selected>Seleccionar Estudiante</option>
                                                    @foreach ($estudiantes as $est)
                                                        <option value="{{ $est->id }}">{{ $est->persona->nombre }} {{ $est->persona->ap_paterno }} {{ $est->persona->ap_materno }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col">
                                                <select class="form-select" wire:model="selectedMonth">
                                                    <option value="">Seleccionar Mes</option>
                                                    @foreach ($months as $key => $month)
                                                        <option value="{{ $key }}">{{ $month }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select class="form-select" wire:model="selectedYear">
                                                    <option value="">Seleccionar Año</option>
                                                    @for ($year = $startYear; $year <= $endYear; $year++)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select wire:model='selectEstado' class="form-select">
                                                    <option value="" selected>Seleccionar Estado</option>
                                                    <option value="0">Pendientes</option>
                                                    <option value="1">Pagado</option>
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
                                            <th>Monto</th>
                                            <th>Mes</th>
                                            <th>Año</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($resultados && count($resultados) > 0)
                                            @foreach ($resultados as $item)
                                                <tr>
                                                    <td>{{ $item->estudiante->persona->nombre }} {{ $item->estudiante->persona->ap_paterno }} {{ $item->estudiante->persona->ap_materno }}</td>
                                                    <td>{{ $item->monto }}Bs.</td>
                                                    <td>{{ \Carbon\Carbon::create()->month($item->mes)->locale('es_ES')->monthName }}</td>
                                                    <td>{{ $item->anio }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->fecha)->locale('es_ES')->isoFormat('LL') }}</td>
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
