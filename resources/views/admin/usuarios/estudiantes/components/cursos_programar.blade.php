<div class="modal fade" id="cursoModal" tabindex="-1" aria-labelledby="cursoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $curso ? $curso->nombre : '' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <p>{{ $curso ? $curso->descripcion : '' }}</p>
                    @if (count($CursoHabilitado) > 0 && $idSemestre == $estudiante->grado)
                        @foreach($CursoHabilitado as $event)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between text-black">
                                                <div>
                                                    <p><b>Docente:</b> {{$event->docente->persona->nombre}} {{$event->docente->persona->ap_paterno}} {{$event->docente->persona->ap_materno}}</p>
                                                    <p><b>Aula:</b> {{ $event->aula->nombre }}</p>
                                                    <p><b>Turno:</b> {{ $event->horario->turno }}</p>
                                                </div>
                                                <div>
                                                    <p class="h4">
                                                        @if($event->inscripciones()->count() < $event->cupo)
                                                            @if($haProgramadoCurso = $estudiante->inscripciones->contains('curso_id', $event->id))
                                                                <a class="programar-link btn" wire:click='desprogramarCurso({{ $event->id }})' data-bs-dismiss='modal'>
                                                                    <span class="badge bg-danger">Desprogramar</span>
                                                                </a>
                                                            @else
                                                                <a class="programar-link btn" wire:click='programarCurso({{ $event->id }})' data-bs-dismiss='modal'>
                                                                    <span class="badge bg-primary">Programar</span>
                                                                </a>
                                                            @endif
                                                        @else
                                                            <a class="programar-link btn" disabled>
                                                                <span class="badge bg-secondary">Cupo lleno</span>
                                                            </a>
                                                        @endif
                                                    </p>
                                                    <span>Cupos: {{$event->inscripciones()->count()}} / {{ $event->cupo }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center">
                            <p>No hay Cursos Habilitados</p>
                        </div>
                    @endif
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>