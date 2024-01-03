<div>
    <div class="iq-navbar-header" style="height: 80px;"></div> 
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        @if(session('success'))
            <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row text-black">
            <div class="col-xl-12 col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <p class="h6">Criterios</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <form wire:submit.prevent='criterioAdd'>
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-lg-8">
                                            <input type="text" class="form-control form-control-sm" wire:model="criteioEdit.nombre" placeholder="Ingresa un nombre">
                                            @error('criteioEdit.nombre') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm" 
                                                wire:model.lazy="criteioEdit.porcentaje" 
                                                placeholder="%"
                                                wire:change="actualizarTotalCurso"
                                            >
                                            @error('criteioEdit.porcentaje') 
                                                <span class="text-danger">{{ $message }}</span> 
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group col-lg-2">
                                            <input type="numeric" class="form-control form-control-sm" wire:model="totalCurso" disabled>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm" wire:click='resetForm'>Cancelar</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <p class="h6">Categoria del riterios</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <form wire:submit.prevent='categoriaAdd'>
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <select class="form-select form-select-sm" wire:model="cat.criterio" wire:change="obtenerPorcentajeCriterioSeleccionado" required>
                                                <option value="" disabled selected>Seleccionar un criterio</option>
                                                @foreach ($criterios as $crit)
                                                    <option value="{{ $crit->id }}">{{ $crit->nombre }}</option>
                                                @endforeach
                                            </select>
                                            @error('cat.criterio') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group col-lg-8">
                                            <input type="text" class="form-control form-control-sm" wire:model="cat.nombre" placeholder="Ingrese un nombre">
                                            @error('cat.nombre') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <input type="text" class="form-control form-control-sm" wire:model.lazy="cat.porcentaje" placeholder="%" wire:change="calcularTotalCategoria" required>
                                            @error('cat.porcentaje') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <input type="numeric" class="form-control form-control-sm" wire:model="totalPocentCategoria" disabled required>
                                            @error('totalPocentCategoria') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm" wire:click='resetForm'>Cancelar</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Trabajo y Evaluaciones</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @if (count($trabajos) > 0)
                                @foreach ($trabajos as $trab)    
                                    <label class="list-group-item">
                                        <input wire:model="selectedTrabajos.{{ $trab->id }}" class="form-check-input me-1" type="checkbox">
                                        {{ $trab->titulo }}
                                    </label>
                                @endforeach
                            @else
                                <div class="text-center">
                                    <p>No hay tareas ni evaluaciones publicadas</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Criterios de Evaluación</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @forelse ($criterios as $criterio)
                                <div class="list-group-item list-group-item-secondary">
                                    <p wire:click="mostrarModal({{ $criterio->id }}, '0')" style="cursor: pointer;">
                                        {{ $criterio->nombre }}
                                    </p>
                                    @if ($criterio->categorias->isNotEmpty())
                                        @foreach ($criterio->categorias as $categoria)
                                            <li class="list-group-item list-group-item-warning" wire:click="mostrarModal({{ $categoria->id }}, '1')" style="cursor: pointer;">
                                                <i style="padding-right: 20px;" class="bi bi-bookmarks-fill"></i>
                                                {{ $categoria->nombre }}
                                                @if (!empty($categoria->tareas) && $categoria->tareas->isNotEmpty())
                                                    <ul class="list-group">
                                                        @foreach ($categoria->tareas as $tarea)
                                                            <li class="list-group-item" wire:click="mostrarModal({{ $tarea->id }})" style="cursor: pointer;">
                                                                {{ $tarea->titulo }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    @endif
                                    @if ($criterio->trabajos->isNotEmpty())
                                        @foreach ($criterio->trabajos as $trabajo)
                                            <li class="list-group-item list-group-item-link">
                                                <p><i class="bi bi-book"> {{ $trabajo->titulo }}</i></p>
                                            </li>
                                        @endforeach
                                    @endif
                                </div>
                            @empty
                                <div class="text-center">
                                    <p>No hay criterios</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($criterioSeleccionado)
        @include('docente.modal_criterio')
    @endif
    @script
        <script>
            $wire.on('mostrarModal', (data) => {
                $('#confirCriterio').modal('show');
            });
        
            $('#confirCriterio').on('hidden.bs.modal', function () {
                $wire.dispatch('cerrarModal');
            });
        </script>    
    @endscript
</div>
