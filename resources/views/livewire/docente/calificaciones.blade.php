<div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="header-title d-flex align-items-center justify-content-between flex-wrap">
                    <h4 class="card-title mb-0">Calificaciones</h4>
                    @if (auth()->user()->hasRole('Docente'))
                        <div class="d-flex align-items-center flex-wrap">
                            <a class="btn btn-primary" href="{{ route('docente.tareas.criterios', $idCurso) }}">Criterios</a>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if (auth()->user()->hasRole('Docente'))
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        @foreach ($trabajos as $tra)
                                            <th class="text-center"><a href="{{ route('show.tarea', $tra->id )}}">{{ $tra->titulo }}</a></th>
                                        @endforeach
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($estudiantes as $est)
                                        <tr>
                                            <td>{{ $est->persona->nombre }} {{ $est->persona->ap_paterno }} {{ $est->persona->ap_materno }}</td>
                                            @foreach ($trabajos as $tra)
                                                <td class="text-center">{{ $notas[$est->id][$tra->id] ?? 'N/A' }}</td>
                                            @endforeach
                                            <td class="text-center">0</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @elseif(auth()->user()->hasRole('Estudiante'))
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>TITULO</th>
                                        <th class="text-center">NOTA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trabajos as $tra)
                                        <tr>
                                            <td><a href="{{ route('show.tarea', $tra->id )}}">{{ $tra->titulo }}</a></td>
                                            <td class="text-center">{{ $notas[Auth::user()->persona->estudiante->id][$tra->id] ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>Nota Final</td>
                                        <td class="text-center">0</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
