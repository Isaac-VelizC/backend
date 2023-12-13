<div>
    <div class="iq-navbar-header" style="height: 80px;"></div> 
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        @if(session('success'))
            <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-xl-4 col-lg-5">
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
                                <div class="form-group col-lg-12">
                                    <input type="text" class="form-control form-control-sm" wire:model="criteioEdit.nombre" placeholder="Ingresa un nombre">
                                    @error('criteioEdit.nombre') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="form-label">Porcentaje:</label>
                                    <input type="numeric" class="form-control form-control-sm" wire:model="criteioEdit.porcentaje" placeholder="Asigna un %">
                                    @error('criteioEdit.porcentaje') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="form-label">Total:</label>
                                    <input type="numeric" class="form-control form-control-sm" wire:model="criteioEdit.total">
                                    @error('criteioEdit.total') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                            </div>
                        </form>
                        <hr>
                    </div>
                </div>
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
                                    <select class="form-select form-select-sm" wire:model="cat.criterio">
                                        <option value="" disabled selected>Seleccionar un criterio</option>
                                        @foreach ($criterios as $crit)
                                            <option value="{{ $crit->id }}">{{ $crit->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('cat.criterio') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="text" class="form-control form-control-sm" wire:model="cat.nombre" placeholder="Ingrese un nombre">
                                    @error('cat.nombre') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="form-label">Porcentaje:</label>
                                    <input type="numeric" class="form-control form-control-sm" wire:model="cat.porcentaje" placeholder="100">
                                    @error('cat.porcentaje') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="form-label">Total:</label>
                                    <input type="numeric" class="form-control form-control-sm" wire:model="cat.total" placeholder="100">
                                    @error('cat.total') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                            </div>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-7">
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
                                        <input class="form-check-input me-1" type="checkbox">
                                        {{ $trab->titulo }}
                                    </label>
                                @endforeach
                            @else
                                <div class="text-center">
                                    <p>No hay tares ni evaluaciones publicadas</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
