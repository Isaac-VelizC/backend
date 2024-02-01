@extends('layouts.app')

@section('content')
<div class="position-relative iq-banner">
    <div class="iq-navbar-header text-black" style="height: 150px;">
       <div class="container-fluid iq-container">
          <div class="row">
                <div class="col-md-12">
                    <div>
                        <h5>{{ Breadcrumbs::render($isEditing ? 'Inventario.edit' : 'Inventario.create') }}</h5>
                    </div>
                </div>
          </div>
       </div>
    </div>
 </div>
 @include('admin.recetas.ingredientes.modal_create')
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">                
        <div class="col-sm-12 col-lg-12">
            @if(session('success'))
                <div id="myAlert" class="alert alert-left alert-warning alert-dismissible fade show mb-3 alert-fade" role="alert">
                    <span>{{ session('success') }} Ya puede Buscar el Ingrediente</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
                    <span>{{ session('error') }}</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="new-user-info">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                            <h4 class="card-title">{{ $isEditing ? 'Editar' : 'Registrar nuevo ' }} ingrediente</h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <form class="needs-validation" novalidate method="POST" action="{{ $isEditing ? route('admin.gestion.inventario.update', $invetario->id) : route('admin.gestion.inventario.store') }}">
                                    @csrf
                                    @if ($isEditing)
                                        @method('PUT')
                                    @endif
                                    <div class="col-sm-12 col-lg-12">
                                        <div class="row">
                                            <div class="form-group col-lg-10">
                                                <label class="form-label"> <span class="text-danger">*</span> Ingrediente:</label>
                                                <select id="ingrediente" class="form-select" name='ingredientes'></select>
                                                @error('ingredientes')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                @if ($isEditing)
                                                    <input type="hidden" name="default" value="{{ $isEditing ? $invetario->ingrediente_id : '' }}">
                                                    <p class="text-success">El ingrediente es <b>{{ $invetario->ingrediente->nombre }}</b> "Puede cambiar el Ingrediente seleccionando otro o registrar uno nuevo"</p>
                                                @endif
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label class="form-label"></label>
                                                <button type="button" class="form-control btn btn-link" data-bs-toggle="modal" data-bs-target="#formIngrediente">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 10h-10v-10h-4v10h-10v4h10v10h4v-10h10z"/></svg>
                                                </button>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="form-label"><span class="text-danger">*</span> Cantidad:</label>
                                                <input type="number" class="form-control" name='cantidad' value="{{ $isEditing ? $invetario->cantidad : '' }}" placeholder="Cantidad" required>
                                                @error('cantidad')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="form-label"><span class="text-danger">*</span> Unidad medida:</label>
                                                <!--input type="text" class="form-control" name="unidad" value="{{ $isEditing ? $invetario->unidad_media : '' }}" placeholder="Unidad Media" required-->
                                                <select class="form-select" id="unidadMedida" name="unidad">
                                                    
                                                    <!-- Volumen -->
                                                    <optgroup label="Volumen">
                                                        <option value="metroCubico">Metro cúbico (m³)</option>
                                                        <option value="litro">Litro (L)</option>
                                                        <option value="mililitro">Mililitro (ml)</option>
                                                        <option value="centimetroCubico">Centímetro cúbico (cm³)</option>
                                                    </optgroup>
                                                
                                                    <!-- Peso/Masa -->
                                                    <optgroup label="Peso/Masa">
                                                        <option value="kilogramo">Kilogramo (kg)</option>
                                                        <option value="gramo">Gramo (g)</option>
                                                        <option value="miligramo">Miligramo (mg)</option>
                                                        <option value="toneladaMetrica">Tonelada métrica (t)</option>
                                                    </optgroup>
                            
                                                    <!-- Volumen (Cocina) -->
                                                    <optgroup label="Volumen (Cocina)">
                                                        <option value="taza">Taza</option>
                                                        <option value="cucharada">Cucharada</option>
                                                        <option value="cucharadita">Cucharadita</option>
                                                        <option value="litroCocina">Litro (L)</option>
                                                        <option value="mililitroCocina">Mililitro (ml)</option>
                                                    </optgroup>
                                                </select>
                                                @error('unidad')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancelar</button>
                                        <button class="btn btn-danger" type="submit">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
            $("#ingrediente").select2({
                placeholder: 'Escriba el nombre',
                allowClear: true,
                ajax: {
                    url: "{{ route('admin.buscar-ingredientes') }}",
                    type: "post",
                    delay: 250,
                    dataType: 'json',
                    data: function(params) {
                        return {
                            nombre: params.term,
                            "_token": "{{ csrf_token() }}",
                        };
                    },
                    processResults:function(data){
                        return {
                            results: $.map(data.data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.nombre
                                }
                            })
                        };
                    },
                },
            });
        });
    </script>
 @endsection