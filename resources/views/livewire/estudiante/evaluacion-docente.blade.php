<div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            @if(session('error'))
                <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
                    <span>{{ session('error') }}</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    @if ($estado)
                        <div class="row">
                            <div class="text-center">
                                <h4 class="card-title mb-0">PREGUNTAS DE EVALUACIÓN AL DOCENTE</h4>
                            </div>    
                            <p>Docente: {{ $curso->docente->persona->nombre }} {{ $curso->docente->persona->ap_paterno }} {{ $curso->docente->persona->ap_materno }}</p>
                            <p>Materia: {{ $curso->curso->nombre }}</p>
                        </div>
                        <hr>
                        <form method="POST" action="{{ route('store.evaluacion.docente') }}">
                            @csrf
                            <input type="hidden" name="idEvaluacion" value="{{ $evalId }}">
                            <input type="hidden" name="idCurso" value="{{ $curso->id }}">
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
                                                    <td style="white-space: pre-wrap;">{{ $pregunta->numero }} - {{ $pregunta->texto }}</td>
                                                    <td class="text-center">
                                                        <input type="radio" name="respuesta[{{ $pregunta->id }}]" value="Mal" {{$stadoEvaluacion ? 'disabled' : '' }} class="form-check-input" {{ ($respuestasEstudiante[$pregunta->id] ?? '') === 'Mal' ? 'checked' : '' }}>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="radio" name="respuesta[{{ $pregunta->id }}]" value="Regular" {{$stadoEvaluacion ? 'disabled' : '' }} class="form-check-input" {{ ($respuestasEstudiante[$pregunta->id] ?? '') === 'Regular' ? 'checked' : '' }}>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="radio" name="respuesta[{{ $pregunta->id }}]" value="Bueno" {{$stadoEvaluacion ? 'disabled' : '' }} class="form-check-input" {{ ($respuestasEstudiante[$pregunta->id] ?? '') === 'Bueno' ? 'checked' : '' }}>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="radio" name="respuesta[{{ $pregunta->id }}]" value="Muy Bueno" {{$stadoEvaluacion ? 'disabled' : '' }} class="form-check-input" {{ ($respuestasEstudiante[$pregunta->id] ?? '') === 'Muy Bueno' ? 'checked' : '' }}>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td style="white-space: pre-wrap;">Comentario (Opcional)</td>
                                                <td colspan="4">
                                                    <textarea name="comentario" class="form-control" {{$stadoEvaluacion ? 'disabled' : '' }} >{{ $comentario ?? '' }}</textarea>
                                                </td>
                                            </tr>
                                        </tbody>
                                    @else
                                        <p class="text-black text-center">No hay preguntas</p>
                                    @endif
                                </table>
                                @if (!$stadoEvaluacion)
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-secondary">Enviar</button>
                                    </div>
                                @endif
                            </div>
                        </form>
                    @else
                        <br>
                        <p class="text-center">No esta habilitado</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
