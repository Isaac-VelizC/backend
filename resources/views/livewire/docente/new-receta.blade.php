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
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Registra Nueva Receta</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <form class="needs-validation" novalidate id="formHabilitarDesabilitar" wire:submit.prevent='guardarReceta' enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label text-black"><span class="text-danger">*</span> Titulo</label>
                                    <input type="text" class="form-control" wire:model="recetaEdit.titulo" placeholder="Dale un nombre a tu receta" required wire:change="activarBoton">
                                    @error('recetaEdit.titulo') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>  
                                <div class="form-group col-md-6">
                                    <label class="form-label"><span class="text-black">Foto</span> (Opcional)</label>
                                    <input type="file" class="form-control" wire:model="imagen">
                                    @error('imagen') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>                                  
                                <div class="form-group col-md-12">
                                    <label class="form-label"><span class="text-black">Descripción</span> (Opcional)</label>
                                    <textarea type="text" class="form-control" wire:model="recetaEdit.descripcion" placeholder="Escribe una breve descripción para la receta"></textarea>
                                    @error('recetaEdit.descripcion') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label text-black">Porciones</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-light btn-sm" wire:click='decrementPorcion'>
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <input style="width: 100px; border:none; text-align: center;" type="numeric" wire:model="porcion" readonly>
                                        <button type="button" class="btn btn-light btn-sm" wire:click='incrementPorcion'>
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label"><span class="text-black">Tiempo en minutos</span> (Opcional)</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-light btn-sm" wire:click='decrementar'>
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <input style="width: 100px; border:none; text-align: center;" type="numeric" wire:model="tiempo" readonly>
                                        <button type="button" class="btn btn-light btn-sm" wire:click='incrementar'>
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                    @error('tiempo') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label text-black"><span class="text-danger">*</span> Ocasión</label>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <input type="checkbox" wire:model="ocasion" value="Desayuno" class="form-check-input">
                                            <label class="form-check-label">Desayuno</label>
                                            <input type="checkbox" wire:model="ocasion" value="Comida" class="form-check-input">
                                            <label class="form-check-label">Comida</label>
                                            <input type="checkbox" wire:model="ocasion" value="Cena" class="form-check-input">
                                            <label class="form-check-label">Cena</label>
                                            <input type="checkbox" wire:model="ocasion" value="Postre" class="form-check-input">
                                            <label class="form-check-label">Postre</label>
                                        </div>
                                    </div>
                                    @error('ocasion') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label text-black"><span class="text-danger">*</span>Ingredientes</label>
                                    <input type="button" class="form-control" value="Escribe ingredientes" readonly data-bs-toggle="modal" data-bs-target="#selectIngrediente">
                                </div>
                                @include('admin.recetas.widgets.select_ingrediente')
                                @if (count($ingredientesSeleccionados) > 0)
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <ul class="list-inline m-0 p-0">
                                                    @foreach ($ingredientesSeleccionados as $item)
                                                        <li class="d-flex mb-4 align-items-center">
                                                            <img src="{{ asset('img/frutas-verduras.png')}}" alt="story-img" class="rounded-pill avatar-40">
                                                            <div class="ms-3 flex-grow-1" style="cursor: pointer;" readonly wire:click="modalIngredietneCantidaUnid({{$item['id']}})">
                                                                <h6>{{ $item['nombre'] }}</h6>
                                                                <p class="mb-0">{{$item['cantidad']}} {{$item['unidades']}}</p>
                                                            </div>
                                                            @include('admin.recetas.widgets.modal_ingrediente', ['idModal' => $item['id'], 'abrirModalIngrediente' => 'abrirModalIngrediente'])
                                                            <div class="dropdown">
                                                                <i class="bi bi-trash btn" wire:click="eliminarIngrediente({{ $item['id'] }})"></i>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group col-md-12">
                                    <label class="form-label"><span class="text-black">Instrucciones</span> (Opcional)</label>
                                    @foreach ($pasos as $indice => $paso)
                                        <div class="d-flex align-items-center" wire:key='{{ $indice }}'>
                                            <textarea type="text" class="form-control" wire:model="pasos.{{ $indice }}.descripcion" placeholder="Añade el paso {{ $this->numeroALetras($paso['numero']) }}" required></textarea>
                                            <div class="d-flex align-items-center flex-wrap">
                                                <span class="badge bg-info rounded-pill">{{ $paso['numero'] }}</span>
                                                <i class="bi bi-trash" wire:click='eliminarPaso({{ $indice }})'></i>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                    <div>
                                        <a href="#" class="btn btn-sm btn-icon btn-ligth" wire:click.prevent="addPaso">
                                            <p class="text-black"><i class="bi bi-plus-circle"></i> Añadir Paso</p>
                                        </a>
                                    </div>
                                    @error('pasoEdit.descripcion') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success" wire:loading.attr="disabled" @if(empty($recetaEdit['titulo']) || !$botonActivado) disabled @endif>Guardar</button>
                                    <a type="button" class="btn btn-danger" onclick="window.history.back()">Salir</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @script
        <script>
            $wire.on('abrirModalIngrediente', (data) => {
                var modalId = 'ingedienteModal' + data;
                var modal = new bootstrap.Modal(document.getElementById(modalId));
                modal.show();
            });
        </script>
    @endscript
</div>
