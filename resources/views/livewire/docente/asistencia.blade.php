<div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <h4 class="card-title mb-0">Control de Asistencia</h4>
                    <div class="d-flex align-items-center flex-wrap">
                        @if ($materia->estado == 1)
                            <button class="btn btn-link" class="button" wire:click='exportAsistenciaPDF'>
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                    <path d="M23 0v20h-8v-2h6v-16h-18v16h6v2h-8v-20h22zm-12 13h-4l5-6 5 6h-4v11h-2v-11z"/>
                                </svg>
                            </button>
                        @endif
                        <div class="dropdown me-3">{{ strftime('%A, %e de %B de %Y', strtotime($fechaAsistencia)) }}</div>
                    </div>
                </div>
                @if(session('message'))
                    <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
                    <span>{{ session('message') }}</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
                    <span>{{ session('error') }}</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">ESTUDIANTE</th>
                                    <th class="text-center">PRESENTE</th>
                                    <th class="text-center">FALTA</th>
                                    <th class="text-center">LICENCIA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estudiantes as $est)
                                    <tr class="">
                                        <td class="">{{ $est->persona->nombre }} {{ $est->persona->ap_paterno }} {{ $est->persona->ap_materno }}</td>
                                        <td class="text-center">
                                            <input type="radio" class="form-check-input" wire:model.defer="asistencia.{{$est->id}}" id="P_{{$est->id}}" value="P" @if ($fechaAsistencia == now()->toDateString()) checked @endif>
                                        </td>
                                        <td class="text-center">
                                            <input type="radio" class="form-check-input" wire:model.defer="asistencia.{{$est->id}}" id="F_{{$est->id}}" value="F" @if ($fechaAsistencia == now()->toDateString()) checked @endif>
                                        </td>
                                        <td class="text-center">
                                            <input type="radio" class="form-check-input" wire:model.defer="asistencia.{{$est->id}}" id="L_{{$est->id}}" value="L" @if ($fechaAsistencia == now()->toDateString()) checked @endif>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($materia->estado == 1)
                            <div class="text-center">
                                <a wire:click='guardarAsistencia()' type="button" class="btn btn-primary">Guardar</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
