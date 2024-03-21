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
                        <div class="d-flex align-items-center flex-wrap">
                            <a class="btn btn-sm btn-icon btn-light" href="{{ route('receta.generadas.list') }}">Recetas Generadas</a>
                            <a class="btn btn-sm btn-icon btn-light" href="{{ route('recetas.add') }}">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                    <path d="M8.742 2.397c.82-.861 1.977-1.397 3.258-1.397 1.282 0 2.439.536 3.258 1.397.699-.257 1.454-.397 2.242-.397 3.587
                                     0 6.5 2.912 6.5 6.5 0 2.299-1.196 4.321-3 5.476v9.024h-18v-9.024c-1.803-1.155-3-3.177-3-5.476 0-3.588 2.913-6.5 6.5-6.5.788 
                                     0 1.543.14 2.242.397zm6.258 19.603h5v-7.505c-.715.307-1.38.47-1.953.525-.274.026-.518-.176-.545-.45-.025-.276.176-.52.451-.545 1.388-.132
                                      5.047-1.399 5.047-5.525 0-3.036-2.465-5.5-5.5-5.5-1.099 0-1.771.29-2.512.563-1.521-1.596-2.402-1.563-2.988-1.563-.595 0-1.474-.026-2.987
                                       1.563-.787-.291-1.422-.563-2.513-.563-3.035 0-5.5 2.464-5.5 5.5 0 4.13 3.663 5.394 5.048 5.525.274.025.476.269.45.545-.026.274-.27.476-.545.45-.573-.055-1.238-.218-1.953-.525v7.505h5v-3.5c0-.311.26-.5.5-.5.239 0 .5.189.5.5v3.5h4v-3.5c0-.311.26-.5.5-.5s.5.189.5.5v3.5z"/>
                                </svg> Registrar Receta
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