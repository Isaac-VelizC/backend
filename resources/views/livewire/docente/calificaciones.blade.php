<div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="header-title d-flex align-items-center justify-content-between flex-wrap">
                    <h4 class="card-title mb-0">Calificaciones</h4>
                    <div class="d-flex align-items-center flex-wrap">
                        <a class="btn btn-primary" href="{{ route('docente.tareas.criterios', $idCurso) }}">Criterios</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
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
                                        <td class="text-center">55</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
