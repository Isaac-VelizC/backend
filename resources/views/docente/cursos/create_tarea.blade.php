@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 80px;"></div> 
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        @if(session('error'))
            <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <form class="text-black" method="POST" action='{{ route('guardar.tarea.new') }}'>
                @csrf
                <div class="text-center">
                    <button type="submit" class="btn btn-secondary btn-sm">Guardar</button>
                    <button type="button" class="btn btn-outline-danger btn-sm">Cancelar</button>
                </div><hr>
                <div class="row">
                    <div class="col-xl-8 col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="form-label">Titulo: *</label>
                                        <input type="text" class="form-control" name="titulo" placeholder="Dale un titulo" required>
                                        @error('titulo') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Tema:</label>
                                        <select class="form-control" name="tema">
                                            <option value="" selected>Sin Tema</option>
                                                @foreach ($temasCurso as $item)
                                                    <option value="{{$item->id}}">{{ $item->tema }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Fecha Limite</label>
                                        <input type="date" class="form-control" name="fin" min="{{ now()->format('Y-m-d') }}">
                                        @error('fin') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <input type="radio" name="tipo_trabajo" value="Practico" class="form-check-input" checked>
                                                <label class="form-check-label">Práctico</label>
                                                <input type="radio" name="tipo_trabajo" value="Teorico" class="form-check-input">
                                                <label class="form-check-label">Teórico</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input class="form-check-input" type="checkbox" name='evaluacion'>
                                                <label class="form-label text-black">Examén:</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input class="form-check-input" type="checkbox" name='con_nota'>
                                                <label class="form-label text-black">Sin Nota:</label>
                                            </div>
                                        </div>
                                        @error('tipo_trabajo') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Ingredientes:</label>
                                        <select id="tags" class="form-select" name="tags[]" multiple="multiple"></select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="form-label" for="recetas">Recetas:</label>
                                        <select id="recetas" class="form-select" name="recetas"></select>
                                        @error('recetas')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" value="{{$id}}" name="curso">
                                <div class="">
                                    <label class="form-label">Instrucciones (Opcional)</label>
                                    <textarea class="form-control" name='descripcion' id="editorTarea" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@section('scripts')
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#editorTarea'))
            .catch(error => {
                console.error(error);
            });
    
        function initializeSelect2(selector, route) {
            $(document).ready(function () {
                $(selector).select2({
                    placeholder: 'Escriba el titulo',
                    allowClear: true,
                    ajax: {
                        url: route,
                        type: 'post',
                        delay: 250,
                        dataType: 'json',
                        data: function (params) {
                            return {
                                name: params.term,
                                "_token": "{{ csrf_token() }}",
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        id: item.id,
                                        text: item.titulo || item.nombre
                                    }
                                })
                            };
                        },
                    },
                });
            });
        }
    
        initializeSelect2("#recetas", "{{ route('search.recetas') }}");
        initializeSelect2("#tags", "{{ route('search.ingredientes') }}");
    </script>
<script>
    // Selecciona el campo de entrada del título
    const tituloInput = document.querySelector('input[name="titulo"]');
    const idInput = document.querySelector('input[name="curso"]');
    // Agrega un evento de entrada al campo de título
    tituloInput.addEventListener('blur', function() {
        // Obtén el valor del título
        const titulo = tituloInput.value;
        const idCurso = idInput.value;
        if (titulo.trim() !== '' && idCurso) {
            // Crea una instancia de FormData
            const formData = new FormData();
            formData.append('titulo', titulo);
            formData.append('idCurso', idCurso);
            console.log(idCurso);
            axios.post('/crear/tarea', formData)
                .then(response => {
                    const tareaId = response.data.id;
                    console.log('ID de la tarea creada:', tareaId);
                })
                .catch(error => {
                    console.error('Error al crear la tarea:', error);
                });
        }
    });
</script>

 @endsection
@endsection