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
            @if(session('message'))
                <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
                    <span>{{ session('message') }}</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="header-title d-flex align-items-center justify-content-between flex-wrap">    
                    <h4 class="card-title mb-0">Calificaciones</h4>
                    @if (auth()->user()->hasRole('Docente') && $materia->estado == 1)
                        <div class="d-flex align-items-center flex-wrap">
                            <button class="btn btn-secondary" type="button" wire:click='calcularNotas'>Calcular Notas</button>
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
                                            <th class="text-center">
                                                @if ($materia->estado == 1)
                                                    <a href="{{ route('show.tarea', $tra->id )}}">{{ $tra->titulo }}</a>
                                                @else
                                                    {{ $tra->titulo }}
                                                @endif
                                            </th>
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
                                            <td class="text-center">{{ $notas[$est->id]['notaFinal'] ?? 'N/A' }}</td>
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
                                        <td class="text-center">{{ $notas[Auth::user()->persona->estudiante->id]['notaFinal'] ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                        @role('Docente')
                            <div class="col-sm-12">
                                <div class="d-flex justify-content-center mt-4">
                                <button type="button" class="btn btn-link" wire:click='descargarNotasFinalesEXCEL'>
                                    <i class="bi bi-file-earmark-excel"></i>
                                    Exportar Excel
                                </button>
                                <button type="button" class="btn btn-link" wire:click='descargarNotasFinalesPDF'>
                                    <i class="bi bi-filetype-pdf"></i>
                                    Descargar PDF
                                </button>
                                </div>
                            </div>
                        @endrole
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
