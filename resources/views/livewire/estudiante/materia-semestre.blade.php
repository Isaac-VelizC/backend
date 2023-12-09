<div>
    @if(session('success'))
       <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
           <span>{{ session('success') }}</span>
           <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
       </div>
   @endif
    @if (count($semestres))
        <div class="card-header">
            <nav class="nav">
                @foreach ($semestres as $semest)
                    <a class="nav-link btn {{ $semest->id == $semestreActivo ? 'active' : '' }}" wire:click='cursosSemestre({{ $semest->id }})'>{{ $semest->nombre }}</a>
                @endforeach
            </nav>
        </div>
        <div class="card-body">
            <div class="new-user-info">
                <div class="row">
                    @if ($materias->count() > 0)
                        @foreach ($materias as $item)
                        <div class="col-lg-4 col-md-12">
                            <a type="button" wire:click='showMateria({{ $item->id }})'>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-grid grid-flow-col align-items-center justify-content-between mb-2">
                                            <div class="d-flex align-items-center text-black">
                                                <p class="mb-0 h6">{{ $item->nombre }}</p>
                                            </div>
                                            <div class="dropdown">
                                                <p class="h6"><span class="badge bg-light text-dark">0</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                    @else
                        <p class="text-center">No hay materias en el periodo, selecciona otro</p>
                    @endif
                </div>
            </div>
            @include('admin.usuarios.estudiantes.components.cursos_programar')
        </div>
    @endif
@script
    <script>
        $wire.on('materiaShown', (event) => {
            // Abrir el modal
            $('#cursoModal').modal('show');
        });
    </script>
@endscript
</div>
