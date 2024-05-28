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
                                    <span class="dropdown-toggle align-items-center d-flex" id="dropdownMenuButton04" role="button" data-bs-toggle="dropdown">
                                        <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" fill="none">
                                            <g>
                                                <path d="M12.0711 18.9706V4.82847M19.1421 11.8995H5" stroke="currentColor" stroke-linecap="round"/>
                                            </g>
                                        </svg> Agregar Nuevo
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton04">
                                        <a class="dropdown-item btn" href="{{ route('nueva.tarea.docente', $materia->id) }}">Tarea</a>
                                        <a class="dropdown-item btn" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-controls="collapseThree" wire:click='abrirFormTema' onclick="cambiarTextoDropdown('Tema')">Tema</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <p>{!! $materia->descripcion !!}</p>
                    @if ($materia->documentos)
                        @foreach ($materia->documentos as $file)
                            <ol class="list-group">
                                <a href="{{ asset($file->url) }}">
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                            <path d="M22 24h-18v-22h12l6 6v16zm-7-21h-10v20h16v-14h-6v-6zm-1-2h-11v21h-1v-22h12v1zm2 7h4.586l-4.586-4.586v4.586z"/>
                                        </svg>
                                        <div class="me-auto">
                                            <div class="fw-bold">{{ $file->nombre }}</div>
                                        </div>
                                    </li>
                                </a>
                            </ol>
                        @endforeach
                    @endif
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
                @if (auth()->user()->hasRole('Docente') && $materia->estado == 1)
                    <div class="accordion-item">
                        <div id="collapseThree" class="accordion-collapse collapse {{ $AD3 ? 'show' : '' }}" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <form class="needs-validation" novalidate wire:submit.prevent="formTema" >
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Titulo del Tema</label>
                                        <input type="text" class="form-control" wire:model='tema' required>
                                        @error('tema') <span class="text-danger">{{ $message }}</span> @enderror
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
                    <form class="comment-text d-flex align-items-center needs-validation" novalidate wire:submit.prevent="addComentario">
                        <textarea type="text" class="form-control rounded" wire:model='comentario' placeholder="Anunciar algo a la clase" required></textarea>
                        <div class="comment-attagement d-flex">
                            <button type="submit" class="text-body btn btn-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M24 0l-6 22-8.129-7.239 7.802-8.234-10.458 7.227-7.215-1.754 24-12zm-15 16.668v7.332l3.258-4.431-3.258-2.901z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h4 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#acordeonComenterio" aria-expanded="true" aria-controls="acordeonComenterio">
                                    Comentarios del cursos
                                </button>
                            </h4>
                            <div id="acordeonComenterio" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="card">
                                        <div class="card-body">
                                            @if (count($comentariosCurso) > 0)
                                                @foreach ($comentariosCurso as $coment)
                                                    <div class="d-grid grid-flow-col justify-content-between">
                                                        <div class="twit-feed">
                                                            <div class="d-flex align-items-center">
                                                                <img class="rounded-pill img-fluid avatar-50 me-3 p-1" src="{{ asset($coment->autor->persona->photo != 'user.png' ? 'storage/' . $coment->autor->persona->photo : 'img/user.png') }}" alt="">
                                                                <div class="media-support-info">
                                                                    <h6 class="mb-0">{{ $coment->autor->name }}</h6>
                                                                    <div class="twit-date">{{ $coment->created_at }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="media-support-body">
                                                                <p class="mb-0">{{ $coment->body }}</p>
                                                            </div>
                                                        </div>
                                                        @if (auth()->user()->id == $coment->autor->id)
                                                        <i class="bi bi-trash btn text-danger" wire:click='deleteComentario({{ $coment->id }})'></i>
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
                <h4 class="mb-3">{{ $item->tema }}</h4>
                @if ($materia->estado == 1)
                    @role('Docente')
                        <div>
                            <a type="button" class="btn btn-light" href="{{ route('docente.edit.tema', $item->id) }}">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-danger" wire:click='borrarTema({{$item->id}})'>
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    @endrole
                @endif
            </div>
            <p>{!! $item->descripcion !!}</p>
            @if ($item->files && count($item->files) > 0)
                @foreach ($item->files as $file)
                <a href="{{ asset($file->url) }}" download="{{ $file->nombre }}">{{ $file->nombre }}</a><br>
                @endforeach
            @endif
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