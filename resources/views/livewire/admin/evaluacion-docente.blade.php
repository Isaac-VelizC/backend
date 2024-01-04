<div>
    <div class="position-relative iq-banner">
        <div class="iq-navbar-header" style="height: 200px;">
            <div class="container-fluid iq-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                            <div>                          
                                <h4>{{ Breadcrumbs::render('gestion.evaluacion') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-header-img">
                <img src="{{ asset('img/portada.jpg') }}" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
            </div>
        </div>
    </div>
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-md-12">
            @if(session('error'))
                <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
                    <span>{{ session('error') }}</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('message'))
                <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
                    <span>{{ session('message') }}</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
                <div class="row row-cols-1">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="row no-gutters">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="text-center">
                                            <h4 class="card-title mb-0">EVALUACIÓN AL DOCENTE</h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <form wire:submit.prevent="guardar" class="form needs-validation" novalidate>
                                        <div class="input-group">
                                            <input wire:model="textPregunta" type="text" class="form-control" placeholder="* Escribe la pregunta" required>
                                        </div>
                                        @error('textPregunta') <span class="text-danger">{{ $message }}</span> @enderror
                                        <hr>
                                        <div class="row">
                                            <div class="text-center">
                                                <button type="button" wire:click="cancelar" class="btn btn-secondary btn-sm">Cancelar</button>
                                                @if($modoEdicion)
                                                    <button type="button" wire:click="borrar" class="btn btn-danger btn-sm">Borrar</button>
                                                @endif
                                                <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="text-center">
                                        <h4 class="card-title mb-0">PREGUNTAS DE EVALUACIÓN AL DOCENTE</h4>
                                    </div>
                                    <p>descripcion</p>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        @if (count($preguntas) > 0)
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="text-center">MAL</th>
                                                <th class="text-center">REGULAR</th>
                                                <th class="text-center">BUENO</th>
                                                <th class="text-center">MUY BUENO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($preguntas as $pregunta)
                                                <tr>
                                                    <td style="white-space: pre-wrap;" wire:click='seleccionPregunta({{$pregunta->id}})'>{{ $pregunta->numero }} - {{ $pregunta->texto }}</td>
                                                    <td class="text-center">
                                                        <input type="radio" class="form-check-input">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="radio" class="form-check-input">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="radio" class="form-check-input">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="radio" class="form-check-input">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @else
                                            <p class="text-black text-center">No hay preguntas</p>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
