@extends('layouts.app')

@section('content')
<div class="position-relative iq-banner">
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                        <div>
                            <h4>{{ Breadcrumbs::render('criterios.gestion' ) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.cursos.criterios.modal_new')
@include('admin.cursos.criterios.modal_cat_new')

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
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <p></p>
                        <div class="gap-2">
                            <a data-bs-toggle="modal" data-bs-target="#formCriterioNew" class="btn btn-primary">+ Agregar</a>
                            <a data-bs-toggle="modal" data-bs-target="#formCriterioCatNew" class="btn btn-primary">+ Categoria</a>
                        </div>
                        
                     </div>
                    <br>
                    <div class="header-title">
                        <h4 class="card-title">Criterios de Evaluación</h4>
                    </div>
                    <div class="list-group">
                        @forelse ($criterios as $criterio)
                            <div class="list-group-item list-group-item">
                                <div class=" d-flex justify-content-between align-items-center py-2">
                                    <div>
                                        {{ $criterio->nombre }}
                                        <a class="btn-sm text-secondary" title="Editar" href="{{ route('admin.editar.criterios', $criterio->id) }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a class="btn-sm text-danger" title="Borrar" href="#" data-bs-placement="top" data-bs-toggle="modal" data-bs-target="#deleteCritConfirm{{ $criterio->id }}">
                                            <i class="bi bi-trash"></i>
                                         </a>
                                    </div>
                                    <span class="badge text-black">{{ $criterio->porcentaje }} %</span>
                                </div>
                                @include('admin.cursos.criterios.modal_confirm', ['modalId' => $criterio->id, 'id' => $criterio->id])
                                @if ($criterio->categorias->isNotEmpty())
                                    @foreach ($criterio->categorias as $categoria)
                                        <div class="list-group-item rounded-2 py-2">
                                            <div class="d-flex justify-content-between align-items-center px-1">
                                                <div>{{ $categoria->nombre }}
                                                    <a class="btn-sm text-primary" href="{{ route('admin.editar.cat.criterios', $categoria->id) }}" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a class="btn-sm text-danger" href="#" title="Borrar" data-bs-placement="top" data-bs-toggle="modal" data-bs-target="#deleteCritConfirmCat{{ $categoria->id }}">
                                                        <i class="bi bi-trash"></i>
                                                     </a>
                                                </div>
                                                @include('admin.cursos.criterios.modal_confirm', ['modalId' => $categoria->id, 'id' => $categoria->id])
                                                <span class="badge text-black">{{ $categoria->porcentaje }} %</span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @empty
                            <div class="text-center">
                                <p>No hay criterios</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection