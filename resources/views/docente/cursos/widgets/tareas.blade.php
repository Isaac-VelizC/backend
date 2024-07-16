<div class="col-lg-12">
    <div class="card">
        <div class="card-body text-black">
            <div class="d-grid grid-flow-col align-items-center justify-content-between">
                <a class="btn btn-sm btn-ligth" href="{{ $materia->estado == 1 ? route('show.tarea', $tarea->id) : '' }}">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">
                            <i class="bi bi-journals"></i>
                            {{ $tarea->titulo }}
                        </p>
                        <i class="bi bi-caret-right-fill"></i>
                        <p class="mb-0">{{ \Carbon\Carbon::parse($tarea->inico)->format('Y-m-d') }} a {{ \Carbon\Carbon::parse($tarea->fin)->format('Y-m-d') }}</p>
                        @role('Estudiante')
                        @php
                            $Entregado  = App\Models\TrabajoEstudiante::where('estudiante_id', $usuariosID)->where('trabajo_id', $tarea->id)->exists();
                        @endphp
                            @if ($Entregado)
                            <div class="text-success">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            @endif
                        @endrole
                    </div>
                </a>
                @if (auth()->user()->hasRole('Docente') && $materia->estado == 1)
                    <div class="dropdown">
                        <span class="h5" id="dropdownMenuButton15" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots"></i>
                        </span>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton15" style="">
                            <a class="dropdown-item cursoMano" href="{{ route('editra.trabajo.docente', $tarea->id) }}">
                                <i class="bi bi-pencil"></i>
                                Editar
                            </a>
                            <a class="dropdown-item cursoMano" wire:click='eliminarTarea({{$tarea->id}})'>
                                <i class="bi bi-trash"></i>
                                Borrar
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>