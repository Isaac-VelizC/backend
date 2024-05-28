@extends('layouts.app')

@section('content')
<div class="position-relative iq-banner">
    <div class="iq-navbar-header" style="height: 150px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                        <h4>{{ Breadcrumbs::render('recetas.all') }}</h4>
                        <div class="d-flex align-items-center flex-wrap gap-4">
                            <a class="btn btn-icon btn-primary" href="{{ route('receta.generadas.list') }}">Recetas
                                IA</a>
                            @role('Docente')
                                <a class="btn btn-icon btn-primary" href="{{ route('recetas.add') }}">Registra Receta </a>
                            @endrole
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
        <div class="col-lg-12">
            <div class="card">
                @if(session('success'))
                <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade"
                    role="alert">
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
                @endif
                @if(session('error'))
                <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade"
                    role="alert">
                    <span>{{ session('error') }}</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
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
                            <label class="form-label text-dark">Seleccionar tipo de plato</label>
                            <div class="mb-3 text-center">
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="tipoPlato" value="Postre" class="form-check-input"
                                        id="disabledRadio2">
                                    <label class="form-check-label" for="disabledRadio2">Postre</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="tipoPlato" value="Desayudo" class="form-check-input"
                                        id="disabledRadio2">
                                    <label class="form-check-label" for="disabledRadio2">Desayudo</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="tipoPlato" value="Almuerzo" class="form-check-input"
                                        id="disabledRadio2">
                                    <label class="form-check-label" for="disabledRadio2">Almuerzo</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="tipoPlato" value="Cena" class="form-check-input"
                                        id="disabledRadio2">
                                    <label class="form-check-label" for="disabledRadio2">Cena</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="tipoPlato" value="Merienda" class="form-check-input"
                                        id="disabledRadio2">
                                    <label class="form-check-label" for="disabledRadio2">Merienda</label>
                                </div>
                            </div>
                            @error('tipoPlato')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label text-dark">Tiempo de preparación</label>
                                    <input type="number" name="tiempo" id="valueTiempo" value="10" class="form-control"
                                        min="10" placeholder="Tiempo minimo 10">
                                </div>
                                <div class="col-6">
                                    <label class="form-label text-dark">Numero de porciones</label>
                                    <input type="number" step="any" name="porcion" value="1" id="valuePorcion"
                                        class="form-control" min="1" placeholder="Canitdad minima 1">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-dark">Seleccionar Ingredientes</label>
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
                    <div id="receta" class="container">
                        {!! $recetas !!}
                        <div style="display: none">{{ $recetas }}</div>
                        <button id="guardarRecetaIA" onclick="guardarRecetaAI()" type="button" class="btn btn-primary">Guardar
                            Receta</button>
                    </div>
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

<script>
    function guardarRecetaAI() {
        // Obtener el contenedor de la receta
        const contenedorReceta = document.querySelector('.container');

        // Obtener el título
        const titulo = contenedorReceta.querySelector('#titulo').innerText;

        // Obtener la lista de ingredientes
        const listaIngredientes = contenedorReceta.querySelectorAll('#ingredientes li');
        const ingredientes = Array.from(listaIngredientes).map(ingrediente => ingrediente.innerText);
        // Obtener los pasos de preparación
        const listaPasos = contenedorReceta.querySelectorAll('#pasos li');
        const pasos = Array.from(listaPasos).map(paso => paso.innerText);
        // Obtener el tiempo estimado de preparación
        const tiempo = contenedorReceta.querySelector('#tiempo').innerText;
        // Obtener la cantidad de porciones
        const porciones = contenedorReceta.querySelector('#porciones').innerText;
        // Crear un objeto con los datos de la receta
        const recetaData = {
            titulo: titulo,
            ingredientes: ingredientes,
            pasos: pasos,
            tiempo: tiempo,
            porciones: porciones
        };
        // Enviar los datos al servidor mediante Axios
        axios.post('/guardar/recipe/generate/AI', recetaData)
            .then(response => {
                console.log(response.data); // Imprimir la respuesta del servidor en la consola
                // Aquí puedes manejar la respuesta del servidor según tus necesidades
            })
            .catch(error => {
                console.error(error); // Imprimir cualquier error en la consola
                // Aquí puedes manejar el error según tus necesidades
            });
    }
</script>
@endsection