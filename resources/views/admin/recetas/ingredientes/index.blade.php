@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 150px;">
    <div class="container-fluid iq-container">
        <div class="row">
            <div class="col-md-12">
                <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                    <div>
                        <h4>{{ Breadcrumbs::render('recetas.lista') }}</h4>
                    </div>
                    <a type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#formIngrediente">
                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                            <path d="M7.902 14c-1.722-1.39-2.902-3.968-2.902-6.037 0-3.094 2.158-4.89 4.187-4.961.841-.013 1.729.199 2.394.57-.175-1.278-.747-2.259-1.344-2.958l1.367-.614c.283.407.572 1.129.761 1.979.383-.695.848-1.262 1.475-1.628.669-.391 1.778-.412 2.518-.272-.187.658-.577 1.513-1.491 2.075-.562.345-1.467.522-2.384.453.042.283.073.574.087.867.682-.364 1.44-.484 2.243-.472 2.029.071 4.187 1.867 4.187 4.961 0 2.069-1.18 4.647-2.902 
                            6.037h6.902v2h-19.5c-.276 0-.5.224-.5.5s.224.5.5.5h19.5v2h-18.5c-.828 0-1.5.672-1.5 1.5s.672 1.5 1.5 1.5h18.5v2h-18.5c-1.932 0-3.5-1.568-3.5-3.5 0-.83.29-1.593.773-2.193-.476-.455-.773-1.097-.773-1.807 0-1.38 1.12-2.5 2.5-2.5h4.402zm15.098 7h-18v-1h18v1zm-12.624-15.6c-1.643
                             1.229-2.035 3.45-.42 6.6-.755-.402-2.37-2.047-2.352-3.945.016-1.676 1.413-2.73 2.772-2.655z"/>
                        </svg> Agregar Ingrediente
                    </a>
                </div>
            </div>
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
                                    <td><p>{{ $item->tiempo ? $item->tiempo : 'No tiene' }}</p></td>
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