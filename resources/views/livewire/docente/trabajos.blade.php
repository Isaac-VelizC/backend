<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <p></p>
                        <div class="d-flex align-items-center flex-wrap">
                            @if (auth()->user()->hasRole('Docente') && $materia->estado == 1)
                            <div class="dropdown me-3">
                                <span class="dropdown-toggle align-items-center d-flex" id="dropdownMenuButton04"
                                    role="button" data-bs-toggle="dropdown">
                                    <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20"
                                        viewBox="0 0 24 24" fill="none">
                                        <g>
                                            <path d="M12.0711 18.9706V4.82847M19.1421 11.8995H5" stroke="currentColor"
                                                stroke-linecap="round" />
                                        </g>
                                    </svg> Agregar Nuevo
                                </span>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton04">
                                    <a class="dropdown-item btn"
                                        href="{{ route('nueva.tarea.docente', $materia->id) }}">Tarea</a>
                                    <a class="dropdown-item btn" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-controls="collapseThree"
                                        wire:click='abrirFormTema' onclick="cambiarTextoDropdown('Tema')">Tema</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @if(session('message'))
                    <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade"
                        role="alert">
                        <span>{{ session('message') }}</span>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                    @endif
                    @if(session('error'))
                    <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade"
                        role="alert">
                        <span>{{ session('error') }}</span>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                    @endif
                    @if (auth()->user()->hasRole('Docente') && $materia->estado == 1)
                    <div class="accordion-item">
                        <div id="collapseThree" class="accordion-collapse collapse {{ $AD3 ? 'show' : '' }}"
                            aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <form class="needs-validation" novalidate wire:submit.prevent="formTema">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Titulo del Tema</label>
                                        <input type="text" class="form-control" wire:model='tema' required>
                                        @error('tema') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" wire:click='resetearForm()'>Cancelar</button>
                                    <button type="submit" class="btn btn-primary" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree">Guardar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    <br>
                    <div class="accordion" id="accordionPlanif">
                        <div class="accordion-item">
                            <h4 class="accordion-header" id="planificacion">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#acordeonPlanif" aria-expanded="true"
                                    aria-controls="acordeonPlanif">
                                    Planificación de la Materia
                                </button>
                            </h4>
                            <div id="acordeonPlanif" class="accordion-collapse collapse"
                                aria-labelledby="planificacion" data-bs-parent="#accordionPlanif">
                                <div class="accordion-body">
                                    <div class="card">
                                        <div class="card-body">
                                            @if (trim($materia->descripcion) == '')
                                                <div class="text-center">
                                                    <p>Aun no hay una planificacion de materia</p>
                                                </div>
                                            @else
                                                <p>{!! $materia->descripcion !!}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($materia->documentos)
                    @foreach ($materia->documentos as $file)
                    <ol class="list-group">
                        <a href="{{ asset($file->url) }}">
                            <li class="list-group-item d-flex justify-content-between align-items-start gap-2">
                                <i class="bi bi-file-text"></i>
                                <div class="me-auto">
                                    <div class="fw-bold">{{ $file->nombre }}</div>
                                </div>
                            </li>
                        </a>
                    </ol>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="comment-text d-flex align-items-center needs-validation" novalidate
                        wire:submit.prevent="addComentario">
                        <textarea type="text" class="form-control rounded" wire:model='comentario'
                            placeholder="Anunciar algo a la clase" required></textarea>
                        <div class="comment-attagement d-flex">
                            <button type="submit" class="text-body btn btn-link">
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </div>
                    </form>

                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h4 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#acordeonComenterio" aria-expanded="true"
                                    aria-controls="acordeonComenterio">
                                    Comentarios del cursos
                                </button>
                            </h4>
                            <div id="acordeonComenterio" class="accordion-collapse collapse"
                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="card">
                                        <div class="card-body">
                                            @if (count($comentariosCurso) > 0)
                                            @foreach ($comentariosCurso as $coment)
                                            <div class="d-grid grid-flow-col justify-content-between">
                                                <div class="twit-feed">
                                                    <div class="d-flex align-items-center">
                                                        <img class="rounded-pill img-fluid avatar-50 me-3 p-1"
                                                            src="{{ asset($coment->autor->persona->photo != 'user.png' ? 'storage/' . $coment->autor->persona->photo : 'img/user.png') }}"
                                                            alt="">
                                                        <div class="media-support-info">
                                                            <h6 class="mb-0">{{ $coment->autor->persona->nombre }} {{
                                                                $coment->autor->persona->ap_paterno }}</h6>
                                                            <div class="twit-date">{{ $coment->created_at }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="media-support-body">
                                                        <p class="mb-0">{{ $coment->body }}</p>
                                                    </div>
                                                </div>
                                                @if (auth()->user()->id == $coment->autor->id)
                                                <i class="bi bi-trash btn text-danger"
                                                    wire:click='deleteComentario({{ $coment->id }})'></i>
                                                @endif
                                            </div>
                                            <hr>
                                            @endforeach
                                            @else
                                            <div class="text-center">
                                                <p>No hay comentarios en este curso</p>
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
        </div>
        <div class="col-lg-12">
            @foreach ($tareas[null] ?? [] as $tarea)
            @include('docente.cursos.widgets.tareas')
            @endforeach
        </div>
        @foreach ($temasCurso as $item)
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <h5 class="mb-3">{{ $item->tema }}</h5>
            @if ($materia->estado == 1)
            @role('Docente')
            <div>
                <a type="button" class="btn btn-sm btn-light" href="{{ route('docente.edit.tema', $item->id) }}">
                    <i class="bi bi-pencil"></i>
                </a>
                <button type="button" class="btn btn-sm btn-danger" wire:click='borrarTema({{$item->id}})'>
                    <i class="bi bi-trash"></i>
                </button>
            </div>
            @endrole
            @endif
        </div>
        <div class="px-5">
            <small>{!! $item->descripcion !!}</small>
            @if ($item->files && count($item->files) > 0)
            @foreach ($item->files as $file)
            <a href="{{ asset($file->url) }}" download="{{ $file->nombre }}">{{ $file->nombre }}</a><br>
            @endforeach
            @endif
        </div>
        @foreach ($tareas[$item->id] ?? [] as $tarea)
        @include('docente.cursos.widgets.tareas')
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