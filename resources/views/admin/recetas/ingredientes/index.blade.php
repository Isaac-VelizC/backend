@extends('layouts.app')

@section('content')
<div class="position-relative iq-banner">
    <div class="iq-navbar-header" style="height: 150px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                        <div>
                            <h4>{{ Breadcrumbs::render('recetas.lista') }}</h4>
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

@include('admin.recetas.ingredientes.modal_create')
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
                                <th>Titulo</th>
                                <th>Porciones</th>
                                <th>Tiempo</th>
                                <th>Ingredientes</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($recetas) > 0)
                                @foreach ($recetas as $item)
                                <tr>
                                    <td><p><a href="{{ route('admin.show.receta', [$item->id]) }}">{{ $item->titulo }}</a></p></td>
                                    <td><p>{{ $item->porcion }}</p></td>
                                    <td><p>{{ $item->tiempo ? $item->tiempo.'min' : 'No tiene' }}</p></td>
                                    <td><p>{{ count($item->ingredientes) }}</p></td>
                                    <td>
                                        <div class="flex align-items-center list-user-action">
                                            <a class="btn btn-sm btn-icon btn-danger" data-bs-placement="top" data-bs-toggle="modal" data-bs-target="#deleteConfirm{{ $item->id }}">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @include('admin.recetas.widgets.modal_eliminar', ['modalId' => $item->id, 'id' => $item->id])
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