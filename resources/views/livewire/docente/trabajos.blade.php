<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <p class="mb-md-0 mb-2 d-flex align-items-center">{{$materia->descripcion}}</p>
                        <div class="d-flex align-items-center flex-wrap">
                            @if (auth()->user()->hasRole('Docente'))
                                <div class="dropdown me-3">
                                    <span class="dropdown-toggle align-items-center d-flex" id="dropdownMenuButton04" role="button" data-bs-toggle="dropdown">
                                        <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" fill="none">
                                            <g>
                                                <path d="M12.0711 18.9706V4.82847M19.1421 11.8995H5" stroke="currentColor" stroke-linecap="round"/>
                                            </g>
                                        </svg> Agregar Nuevo
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton04">
                                        <a class="dropdown-item" href="{{ route('nueva.tarea.docente', $materia->id) }}">Tarea</a>
                                        <a class="dropdown-item" href="{{ route('nueva.pregunta.docente', $materia->id) }}">Pregunta</a>
                                        <a class="dropdown-item cursoMano" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-controls="collapseThree" wire:click='abrirFormTema' onclick="cambiarTextoDropdown('Tema')">Tema</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if(session('message'))
                    <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
                    <span>{{ session('message') }}</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (auth()->user()->hasRole('Docente'))
                    <div class="accordion-item">
                        <div id="collapseThree" class="accordion-collapse collapse {{ $AD3 ? 'show' : '' }}" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <form wire:submit.prevent="formTema">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Titulo del Tema</label>
                                        <input type="text" class="form-control" wire:model='tema'>
                                        @error('tema') <span class="form-text error">{{ $message }}</span> @enderror
                                    </div>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="collapse" data-bs-target="#collapseThree" wire:click='resetearForm()'>Cancelar</button>
                                    <button type="submit" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseThree">Guardar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="comment-text d-flex align-items-center mt-3" action="javascript:void(0);">
                        <textarea type="text" class="form-control rounded" placeholder="Anunciar algo a la clase"></textarea>
                        <div class="comment-attagement d-flex">
                            <a href="javascript:void(0);" class="text-body">
                                <svg class="icon-20" width="20"  viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M20,4H16.83L15,2H9L7.17,4H4A2,2 0 0,0 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6A2,2 0 0,0 20,4M20,18H4V6H8.05L9.88,4H14.12L15.95,6H20V18M12,7A5,5 0 0,0 7,12A5,5 0 0,0 12,17A5,5 0 0,0 17,12A5,5 0 0,0 12,7M12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15Z" />
                                </svg>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            @foreach ($tareas[null] ?? [] as $tarea)
                @include('docente.cursos.widgets.tareas')
            @endforeach
            @foreach ($preguntas[null] ?? [] as $pregunta)
                @include('docente.cursos.widgets.preguntas')
            @endforeach
        </div>
        @foreach ($temasCurso as $item)
            <div class="d-flex align-items-center justify-content-between flex-wrap">        
                @if (auth()->user()->hasRole('Docente'))
                    <h4 class="mb-3">
                        <div class="col-lg-12">
                            <textarea 
                                id="dynamicInput"
                                class="inputEdit" 
                                wire:model="temasEditados.{{ $item->id }}"
                                wire:blur="actualizarTema({{ $item->id }})"
                                @if($temaEditando !== $item->id) disabled @endif
                                style="resize: horizontal;">
                            </textarea>
                        </div>
                    </h4>
                    <div class="d-flex align-items-center flex-wrap">
                        <i wire:click='editarTema({{$item->id}})' class="bi bi-pencil"></i> 
                        <i wire:click='borrarTema({{$item->id}})' class="bi bi-trash cursoMano"></i>
                    </div>
                @elseif(auth()->user()->hasRole('Estudiante'))
                <h4 class="mb-3">{{ $item->tema }}</h4>
                @endif
            </div>
            @foreach ($tareas[$item->id] ?? [] as $tarea)
                @include('docente.cursos.widgets.tareas')
            @endforeach

            @foreach ($preguntas[$item->id] ?? [] as $pregunta)
                @include('docente.cursos.widgets.preguntas')
            @endforeach
        @endforeach
    </div>
</div>

<script>
    document.addEventListener("input", function() {
        var inputElement = document.getElementById("dynamicInput");
        inputElement.style.width = inputElement.scrollWidth + "px";
    });
</script>