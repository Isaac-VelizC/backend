@extends('layouts.app')

@section('content')
    <div class="iq-navbar-header" style="height: 150px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                        <div>
                            <h4>{{ Breadcrumbs::render('materias.tema', $tema) }}</h4> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="iq-header-img">
            <img src="{{ asset('img/fondo1.jpg') }}" alt="header" class="img-fluid w-100 h-100 animated-scaleX">
        </div>
    </div> 
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        @if(session('error'))
            <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8 col-lg-8">
                            <form class="needs-validation" novalidate method="POST" action="{{ route('docente.update.tema', $tema->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label"><span class="text-danger">*</span> Titulo:</label>
                                        <input type="text" name="nombre" placeholder="Ingrese el titulo del tema" value="{{ $tema->tema }}" class="form-control" required>
                                        @error('nombre')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Descripción: (Opcional) </label>
                                        <textarea class="form-control" name="descripcion" id="descripcionId">{!! $tema->descripcion !!}</textarea>
                                        @error('descripcion')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a type="button" class="btn btn-danger" href="{{ route('cursos.curso', $tema->curso_id) }}">Volver</a>
                                    <button class="btn btn-secondary" type="submit">Guardar</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            @livewire('admin.edit-tema', ['id' => $tema->id])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
<script>
   ClassicEditor
         .create( document.querySelector( '#descripcionId' ) )
         .catch( error => {
             console.error( error );
         } );
</script>
@endsection
@endsection