@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 80px;"></div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap text-black">
                        <h4>{{ Breadcrumbs::render('recetas.all') }}</h4>
                        <div class="d-flex align-items-center flex-wrap gap-4">
                            <a class="btn btn-icon btn-primary" href="{{ route('receta.generadas.list') }}">Recetas Generadas</a>
                            <a class="btn btn-icon btn-primary" href="{{ route('recetas.add') }}">
                                 Registrar Receta
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card"> 
                @if(session('success'))
                    <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
                        <span>{{ session('success') }}</span>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
                        <span>{{ session('error') }}</span>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card-header text-center">
                    <div class="header-title">
                        <h4 class="card-title">Generar Receta</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('new.receta.generation') }}">
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="radio" name="tipoPlato" value="cena" class="form-check-input" id="disabledRadio1" checked>
                                    <label class="form-check-label" for="disabledRadio1">Platos</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="tipoPlato" value="Postre" class="form-check-input" id="disabledRadio2">
                                    <label class="form-check-label" for="disabledRadio2">Postre</label>
                                </div>
                            </div>
                            @error('tipoPlato')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="mb-3">
                                <label class="form-label">Ingredientes</label>
                                <select id="tags" class="form-select" name="tags[]" multiple="multiple"></select>
                            </div>
                            @error('tags*')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Procesar</button>
                        </div>
                    </form>
                    <hr>
                    @if ($recetas)
                        {!! $recetas !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script src="{{ asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $("#tags").select2({
            placeholder:'Buscar Ingrediente',
            allowClear:true,
            theme: "classic",
            ajax:{
                url:"{{ route('search.ingredientes') }}",
                type: "post",
                $delay:250,
                dataType:'json',
                data: function(params) {
                    return{
                        name:params.term,
                        "_token":"{{ csrf_token() }}",
                    };
                },
                processResults:function(data){
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text:item.nombre
                            }
                        })
                    };
                },
            },
        });
    });
</script>
@endsection