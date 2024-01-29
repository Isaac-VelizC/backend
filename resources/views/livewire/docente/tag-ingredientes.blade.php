<div>
    <style>
        :root {
        --color-primary: #840ec4;
        --color-text: #444;
        }

        .product-quantity {
            width: 10rem;
            margin: 0 auto;
            display: flex;
        }

        .button-quantity,
        .input-quantity {
        height: 2rem;
        border: 1px var(--color-primary) solid;
        }

        .input-quantity {
            width: 50px;
            font-size: 16px;
            text-align: center;
            border-left: none;
            border-right: none;
            outline: none;
            color: var(--color-text);
        }
    </style>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
               <div class="card-header">
                  <div class="header-title">
                     <h6 class="card-title"><b>Ingredientes disponibles en el inventario</b></h6>
                  </div>
            </div>
               <div class="card-body">
                   <div class="form-group">
                      <ul class="list-group list-group-flush">
                        @foreach ($ingredientes as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-start" wire:click='seleccionarIngrediente({{ $item->id }})'>
                                <div class="fw-bold">{{ $item->ingrediente->nombre }}</div>
                                <span>{{ $item->cantidad }}</span>
                            </li>
                        @endforeach
                      </ul>
                   </div>
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
         <div class="card">
            <div class="card-header">
                @if ($seleccion)
                    <div class="header-title">
                        <h4 class="card-title">Ingredente Seleccionado <b>{{ $seleccion->ingrediente->nombre }}</b></h4>
                    </div>
                    <div class="card-body">
                           <div class="mt-2">
                           <h6 class="mb-1"><b>Tipo de ingrediente:</b></h6>
                           <p>{{ $seleccion->ingrediente->tipo->nombre ?? 'No tiene' ?? 'No tiene' }}</p>
                        </div>
                           <div class="mt-2">
                           <h6 class="mb-1"><b>Unidades Medias:</b></h6>
                           <p>{{ $seleccion->unidad_media ?? 'No tiene' }}</p>
                           </div>
                    </div>
                    <form wire:submit.prevent='guardarHistorial'>
                        @csrf
                        <div class="col-sm-12 col-lg-12">
                            <p><b>Seleccionar cantidad a usar</b></p>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label class="form-label">Cantidad disponible:</label>
                                    <input type="number" class="form-control" wire:model="cantidadSeleccion" disabled>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="form-label">Seleccionar cantidad a usar:</label>
                                    <div class="product-quantity">
                                        <button type="button" class="button-quantity" wire:click="decrement"> - </button>
                                        <input
                                            type="tel"
                                            id="input-quantity"
                                            class="input-quantity js-quantity-counter-input"
                                            value="{{ $quantity }}"
                                            maxlength="2"
                                            required
                                            wire:model="quantity"
                                            required>
                                        <button type="button" class="button-quantity" wire:click="increment"> + </button>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                </div>
                                <!--div class="form-group col-lg-12">
                                    <label class="form-label">Descripción (Opcional):</label>
                                    <textarea class="form-control" rows="2" placeholder="Agrega una pequeña descripcion (Opcional)"></textarea>
                                </div-->
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="reset" class="btn btn-danger" wire:click='resetForm'>Cancelar</button>
                            <button type="submit" class="btn btn-secondary">Guardar</button>
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
                                                <a href="#" wire:click='borrarIngrediente({{ $uso->id }})' 
                                                    {{ now()->diffInHours($uso->fecha) >= 2 ? 'disabled' : '' }}>
                                                    <i class="bi bi-trash"></i>
                                                 </a>
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
</div>