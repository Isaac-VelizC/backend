<div>
    <div class="position-relative iq-banner">
        <div class="iq-navbar-header" style="height: 170px;">
            <div class="container-fluid iq-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                            <div>                          
                                <h4>{{ Breadcrumbs::render('historial.evaluacion') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="row row-cols-1">
                    <div class="overflow-hidden d-slider1 ">
                        @foreach ($materiasHabilitados as $item)
                        <div class="col-lg-2 col-md-12">
                            <a class="card" href="#" wire:click='seleccionarMateria({{ $item->materia->id }})'>
                                <div class="card-body">
                                    <div class="d-grid mb-2">
                                        <div class="d-flex align-items-center text-black">
                                            <p class="mb-0 h6">{{ $item->materia->curso->nombre }}</p>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div> 
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h5 class="card-title">Respuestas {{ $respuestas ? $materiaNombre : '' }}</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($respuestas)
                                    @foreach($porcentajes as $preguntaId => $tiposRespuestas)
                                    <?php 
                                        $pregunta = App\Models\PreguntaEvaluacionDocente::find($preguntaId);
                                        $nombrePregunta = $pregunta ? $pregunta->texto : "Pregunta no encontrada";
                                    ?>
                                        <p> <b>{{ $preguntaId }} {{ $nombrePregunta }}</b></p>
                                        <ul>
                                            @foreach($tiposRespuestas as $tipoRespuesta => $porcentaje)
                                                <li>{{ $tipoRespuesta }}: {{ $porcentaje }}%</li>
                                            @endforeach
                                        </ul>
                                    @endforeach
                                @else
                                    <div class="text-center">
                                        <p>Seleccione una materia para ver las respuestas</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
