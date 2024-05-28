@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-body">
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
        <div class="card-header text-center py-5">
            <div class="header-title">
                <h4 class="card-title">GENERAR RECETA CON INTELIGENCIA ARTIFICIAL</h4>
            </div>
        </div>      
        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('new.receta.generation') }}">
                            @csrf
                            <div class="row">
                                <label class="form-label">Elegir tipo de receta</label>
                                <div class="mb-3 text-center">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="tipoPlato" value="cena" class="form-check-input" id="disabledRadio1" checked>
                                        <label class="form-check-label" for="disabledRadio1">Cena</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="tipoPlato" value="desayuno" class="form-check-input" id="disabledRadio1" checked>
                                        <label class="form-check-label" for="disabledRadio1">Desayuno</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="tipoPlato" value="postre" class="form-check-input" id="disabledRadio2">
                                        <label class="form-check-label" for="disabledRadio2">Postre</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="tipoPlato" value="merienda" class="form-check-input" id="disabledRadio1" checked>
                                        <label class="form-check-label" for="disabledRadio1">Merienda</label>
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
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">PREPARANDO RECETA</h5>
                        <img src="{{ asset('img/esperando.gif') }}" alt="cargando" class="mx-auto d-block">
                    </div>
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