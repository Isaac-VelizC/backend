@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 150px;">
    <div class="container-fluid iq-container">
        <div class="row">
            <div class="col-md-12">
                <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                    <div>
                        <h4>{{ Breadcrumbs::render('Inventario.list') }}</h4>
                    </div>
                    <div>
                        <a class="btn btn-link" href="{{ route('admin.inventario.historial') }}">
                            <i class="bi bi-list-columns"></i> Historial
                        </a>
                        <a class="btn btn-warning" href="{{ route('admin.gestion.inventario.form') }}" >
                            <i class="bi bi-bag-plus"></i> Nuevo
                        </a>
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
     @if(session('error'))
         <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
             <span>{{ session('error') }}</span>
             <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
     @endif
    <div class="row">
       <div class="col-sm-12">
          <div class="card">
             <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Tipo</th>
                                <th>Modificación</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <?php $i = 1; ?>
                        <tbody>
                            @if (count($ingredientes) > 0)
                                @foreach ($ingredientes as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->ingrediente->nombre }}</td>
                                        <td>{{ $item->cantidad }} {{ $item->unidad_media }}</td>
                                        <td>{{ $item->ingrediente->tipo ? $item->ingrediente->tipo->nombre : 'No tiene' }}</td>
                                        <td>{{ $item->fecha_modificacion }}</td>
                                        <td>{{ $item->estado }}</td>
                                        <td>
                                            <div class="flex align-items-center list-user-action">
                                                <a class="btn btn-sm btn-icon btn-light" data-bs-placement="top" data-bs-toggle="modal" data-bs-target="#addCantidad{{ $item->id }}">
                                                    <i class="bi bi-plus-circle-dotted"></i>
                                                </a>
                                                <a class="btn btn-sm btn-icon btn-primary" data-bs-placement="top" href="{{ route('admin.gestion.inventario.edit', $item->id) }}">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a class="btn btn-sm btn-icon btn-danger" data-bs-placement="top" data-bs-toggle="modal" data-bs-target="#deleteConfirm{{ $item->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @include('admin.inventario.modal_confirm')
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
@endsection