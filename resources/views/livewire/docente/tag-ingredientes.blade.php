<div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card-header">
                <div class="header-title">
                    <h6 class="card-title"><b>Ingredientes disponibles en el inventario</b></h6>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <ul class="list-group list-group-flush">
                    @foreach ($ingredientes as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-start" style="cursor: pointer;"
                        @if ($curso->estado == 1)
                            wire:click='seleccionarIngrediente({{ $item->id }})'
                        @endif>
                            <div class="fw-bold">{{ $item->ingrediente->nombre }}</div>
                            <span>{{ $item->cantidad }}</span>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
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
            <div class="pt-4">
                @if ($seleccion)
                    <div class="header-title">
                        <h4 class="card-title">Ingredente Seleccionado <b>{{ $seleccion->ingrediente->nombre }}</b></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                               <h6 class="mb-1"><b>Tipo de ingrediente:</b></h6>
                               <p>{{ $seleccion->ingrediente->tipo->nombre ?? 'No tiene' }}</p>
                            </div>
                            <div class="col-md-6">
                               <h6 class="mb-1"><b>Unidades Medias:</b></h6>
                               <p>{{ $seleccion->unidad_media }}</p>
                            </div>
                        </div>
                        <p>{{ $seleccion->descripcion }}</p>
                    </div>
                    <form wire:submit.prevent='guardarHistorial'>
                        @csrf
                        <div class="col-sm-12 col-lg-12">
                            <h5><b>Seleccionar cantidad a usar</b></h5>
                            <div class="row">
                                <div class="form-group col-lg-2">
                                    <label class="form-label">Disponible:</label>
                                    <input type="number" class="form-control form-control-sm" wire:model="cantidadSeleccion" disabled>
                                </div>
                                <div class="form-group col-lg-10">
                                    <label class="form-label">Seleccionar cantidad a usar:</label>
                                    <div class="product-quantity">
                                        <button type="button" class="btn btn-sm btn-primary" wire:click="decrement"> - </button>
                                        <input
                                            id="input-quantity"
                                            value="{{ $quantity }}"
                                            maxlength="2"
                                            wire:model="quantity"
                                            style="width: 50px; border:none; text-align: center;" type="numeric"
                                            readonly>
                                        <button type="button" class="btn btn-sm btn-primary" wire:click="increment"> + </button>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="text-center">
                            <button type="reset" class="btn btn-sm btn-danger" wire:click='resetForm'>Cancelar</button>
                            <button type="submit" class="btn btn-sm btn-secondary">Guardar</button>
                        </div>
                    </form>
                @else
                    <div class="header-title">
                        <h4 class="card-title">Seleccionar ingrediente a usar</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <ol class="list-group list-group-numbered">
                                @if (count($ingredientesUso) > 0)
                                    @foreach ($ingredientesUso as $uso)
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">{{ $uso->inventario->ingrediente->nombre }}</div>
                                                Cantidad {{ $uso->cantidad }}
                                            </div>
                                            <div>
                                                <span class="badge bg-primary rounded-pill">{{ $uso->fecha }}</span>
                                                @if ($curso->estado == 1)
                                                    <a href="#" wire:click='borrarIngrediente({{ $uso->id }})' 
                                                        {{ now()->diffInHours($uso->fecha) >= 2 ? 'disabled' : '' }}>
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <p class="text-center">No hay Ingredientes que se uso en la materia</p>
                                @endif
                            </ol>
                         </div>
                    </div>
                @endif
            </div>
        </div>
   </div>
</div>