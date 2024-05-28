<div>
    <div class="position-relative iq-banner">
        <div class="iq-navbar-header" style="height: 170px;">
            <div class="container-fluid iq-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                            <div>
                                <h4>{{ Breadcrumbs::render('Inventario.historial') }}</h4>
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
            <div class="col-md-12">
                <div class="row row-cols-1">
                    <div class="col-sm-12">
                        <!--div class="card">
                            <div class="row no-gutters">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="text-center">
                                            <h4 class="card-title mb-0">HISTORIAL DEL INVENTARIO ENTRADAS Y SALIDAS</h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <form class="form" wire:submit.prevent='searchAsistencias'>
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <select wire:model="materia" class="form-select">
                                                    <option value="" selected disabled>Seleccionar una materia</option>
                                                    
                                                </select>
                                            </div>
                                            <div class="col">
                                                <input wire:model='fecha' type="date" class="form-control">
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
                        </div-->
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="text-center">
                                        <h4 class="card-title mb-0">HISTORIAL DEL INVENTARIO ENTRADAS Y SALIDAS</h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                <table id="datatable" class="table table-striped" data-toggle="data-table">
                                    <thead>
                                        <tr>
                                            <th>Ingrediente</th>
                                            <th>Cantidad</th>
                                            <th>Descripcion</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($historial && count($historial) > 0)
                                            @foreach ($historial as $item)
                                                <tr>
                                                    <td>{{ $item->inventario->ingrediente->nombre }}</td>
                                                    <td>{{ $item->cantidad }}</td>
                                                    <td>{{ $item->descripcion }}</td>
                                                    <td>{{ $item->fecha }}</td>
                                                    <td><p> <span class="badge rounded-pill bg-info text-white">{{ $item->estado  ? 'Salida' : 'Entrada' }}</span></p></td>
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
