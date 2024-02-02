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
                <div class="col-xl-12 col-lg-12">
                    @if ($isEditing)
                        <div class="card">
                            <br>
                            <div class="card_body">
                                <div class="row">
                                    <div class="col-md-6">
                                        @if (count($files) > 0)
                                            <div class="text-center"><b>Archivos</b></div>
                                            @foreach ($files as $file)
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <a href="{{ asset($file->url) }}">
                                                        <div class="ms-2 me-auto">
                                                            <div class="fw-bold">{{ $file->nombre }}</div>
                                                        </div>
                                                    </a>
                                                    <a class="badge rounded-pill bg-light text-dark" href="{{ route('docente.borrar.file', $file->id) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                            <path d="M9 13v6c0 .552-.448 1-1 1s-1-.448-1-1v-6c0-.552.448-1 1-1s1 .448 1 1zm7-1c-.552 0-1 .448-1 1v6c0 .552.448 1 1 1s1-.448 1-1v-6c0-.552-.448-1-1-1zm-4 0c-.552 0-1 .448-1 1v6c0 .552.448 1 1 1s1-.448 1-1v-6c0-.552-.448-1-1-1zm4.333-8.623c-.882-.184-1.373-1.409-1.189-2.291l-5.203-1.086c-.184.883-1.123 1.81-2.004 1.625l-5.528-1.099-.409 1.958 19.591 4.099.409-1.958-5.667-1.248zm4.667 4.623v16h-18v-16h18zm-2 14v-12h-14v12h14z"/>
                                                        </svg>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @else
                                            <div class="text-center">
                                                <p>No hay archivos</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        @if (count($ingrests) > 0)
                                        <div class="text-center"><b>Ingredientes</b></div>
                                            @foreach ($ingrests as $item)
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">{{ $item->nombre }}</div>
                                                    </div>
                                                    <span class="badge rounded-pill bg-light text-dark" >
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                            <path d="M9 13v6c0 .552-.448 1-1 1s-1-.448-1-1v-6c0-.552.448-1 1-1s1 .448 1 1zm7-1c-.552 0-1 .448-1 1v6c0 .552.448 1 1 1s1-.448 1-1v-6c0-.552-.448-1-1-1zm-4 0c-.552 0-1 .448-1 1v6c0 .552.448 1 1 1s1-.448 1-1v-6c0-.552-.448-1-1-1zm4.333-8.623c-.882-.184-1.373-1.409-1.189-2.291l-5.203-1.086c-.184.883-1.123 1.81-2.004 1.625l-5.528-1.099-.409 1.958 19.591 4.099.409-1.958-5.667-1.248zm4.667 4.623v16h-18v-16h18zm-2 14v-12h-14v12h14z"/>
                                                        </svg>
                                                    </span>
                                                </li>
                                            @endforeach
                                        @else
                                            <div class="text-center">
                                                <p>No hay ingredientes</p>
                                            </div>
                                        @endif
                                        <hr>
                                        @if ($trabajo->receta_id)
                                            <a href="">{{$trabajo->receta->titulo}}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    @endif
                </div>
            <form class="text-black" method="POST" action='{{ $isEditing ? route('docente.update.trabajo', $trabajo->id) : route('guardar.tarea.new') }}' enctype="multipart/form-data">
                @csrf
                @if ($isEditing)
                    @method('PUT')
                @endif
                <div class="text-center">
                    <button type="submit" class="btn btn-secondary btn-sm">{{ $isEditing ? 'Actualizar' : 'Guardar'}}</button>
                    <button type="button" class="btn btn-outline-danger btn-sm">Cancelar</button>
                </div><hr>
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="form-label">Titulo: *</label>
                                        <input type="text" class="form-control" name="titulo" value="{{ $isEditing ? $trabajo->titulo : '' }}" placeholder="Dale un titulo" required>
                                        @error('titulo') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Tema:</label>
                                        <select class="form-control" name="tema">
                                            <option value="" selected>Sin Tema</option>
                                                @foreach ($temasCurso as $item)
                                                    <option value="{{$item->id}}" {{ $isEditing && $item->id == $trabajo->tema_id ? 'selected' : '' }}>
                                                        {{ $item->tema }}
                                                    </option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Fecha Limite: *</label>
                                        <input type="datetime-local" class="form-control" name="fin" value="{{ $isEditing ? $trabajo->fin : '' }}" min="{{ now()->format('Y-m-d\TH:i') }}" required>
                                        @error('fin') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <input type="radio" name="tipo_trabajo" value="Practico" class="form-check-input" {{ $isEditing && $trabajo->tipo == 'Practico' ? 'checked' : 'checked' }}>
                                                <label class="form-check-label">Práctico</label>
                                                <input type="radio" name="tipo_trabajo" value="Teorico" class="form-check-input" {{ $isEditing && $trabajo->tipo == 'Teorico' ? 'checked' : '' }}>
                                                <label class="form-check-label">Teórico</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="hidden" name="evaluacion" value="0">
                                                <input class="form-check-input" type="checkbox" name='evaluacion' value="1" {{ $isEditing && $trabajo->evaluacion ? 'checked' : '' }}>
                                                <label class="form-label text-black">Examen:</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="hidden" name="con_nota" value="0">
                                                <input class="form-check-input" type="checkbox" name='con_nota' value="1" {{ $isEditing && $trabajo->con_nota ? 'checked' : '' }}>
                                                <label class="form-label text-black">Sin Nota:</label>
                                            </div>
                                        </div>
                                        @error('tipo_trabajo') <span class="text-danger">{{ $message }}</span> @enderror
                                        @error('evaluacion') <span class="text-danger">{{ $message }}</span> @enderror
                                        @error('con_nota') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label class="form-label" for="customFiles">Subir Archivos:</label>
                                        <input class="form-control" type="file" name="files[]" id="customFiles" multiple>
                                        @error('files')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <input type="hidden" value="{{ $isEditing ? $trabajo->curso_id : $id}}" name="curso">
                                    <div class="form-group">
                                        <label class="form-label">Instrucciones (Opcional)</label>
                                        <textarea class="form-control" name='descripcion' id="editorTarea" rows="5">{{ $isEditing ? $trabajo->descripcion : '' }}</textarea>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Ingredientes:</label>
                                        <select id="tags" class="form-select" name="tags[]" multiple="multiple"></select>
                                        @error('tags*')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="form-label" for="recetas">Recetas:</label>
                                        <select id="recetas" class="form-select" name="recetas"></select>
                                        @error('recetas')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
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