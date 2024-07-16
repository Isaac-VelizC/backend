<div>
    <div class="position-relative iq-banner">
        <div class="iq-navbar-header" style="height: 80px;">
            <div class="container-fluid iq-container"></div>
            <div class="iq-header-img">
                <img src="{{ asset('img/fondo1.jpg') }}" alt="header" class="img-fluid w-100 h-100 animated-scaleX">
            </div>
        </div>
    </div>
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        @if(session('error'))
        <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade"
            role="alert">
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if ($errors->any())
        <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade"
            role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
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
                <div class="card-body text-black">
                    <div class="new-user-info">
                        <form class="needs-validation" novalidate id="formHabilitarDesabilitar"
                            wire:submit.prevent='guardarReceta' enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="form-label "><span class="text-danger">*</span> Titulo</label>
                                    <input type="text" class="form-control" wire:model="recetaEdit.titulo"
                                        placeholder="Dale un nombre a tu receta">
                                    @error('recetaEdit.titulo') <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label"><span class="">Foto</span> (Opcional)</label>
                                    <input type="file" class="form-control" wire:model="imagen">
                                    @error('imagen') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label "><span class="text-danger">*</span> Ocasión</label><br>
                                    @foreach (['Desayuno', 'Comida', 'Cena', 'Postre'] as $ocasion)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            wire:model="ocasion.{{ $ocasion }}">
                                        <label class="form-check-label">{{ $ocasion }}</label>
                                    </div>
                                    @endforeach
                                    <br>
                                    @error('ocasion') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Descripción (Opcional)</label>
                                    <textarea type="text" class="form-control" wire:model="recetaEdit.descripcion"
                                        placeholder="Escribe una breve descripción para la receta"></textarea>
                                    @error('recetaEdit.descripcion') <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="form-label">Porciones</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-light btn-sm"
                                            wire:click='decrementPorcion'>
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <input style="width: 50px; border:none; text-align: center;" type="numeric"
                                            wire:model="porcion" readonly>
                                        <button type="button" class="btn btn-light btn-sm"
                                            wire:click='incrementPorcion'>
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="form-label">Tiempo en minutos</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-light btn-sm" wire:click='decrementar'>
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <input style="width: 50px; border:none; text-align: center;" type="numeric"
                                            wire:model="tiempo" readonly>
                                        <button type="button" class="btn btn-light btn-sm" wire:click='incrementar'>
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                    @error('tiempo') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group col-sm-12">
                                    <label class="form-label"><span class="text-danger">*</span>Ingredientes</label>
                                    <button type="button" class="form-control" data-bs-toggle="modal"
                                        data-bs-target="#selectIngrediente">
                                        Buscar ingredientes
                                    </button>
                                </div>
                                @include('admin.recetas.widgets.select_ingrediente')
                                @if (count($ingredientesSeleccionados) > 0)
                                <div class="col-lg-6">
                                    <ul class="list-inline m-0 p-0">
                                        @foreach ($ingredientesSeleccionados as $item)
                                        <li class="d-flex mb-4 align-items-center">
                                            <img src="{{ asset('img/frutas-verduras.png')}}" alt="story-img" class="rounded-pill avatar-40">
                                            <div class="ms-3 flex-grow-1">
                                                <h6 class="py-2">{{ $item['nombre'] }}</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="number" placeholder="Cantidad" wire:change='guardarCantidadUnidades({{$item["id"]}})'
                                                            class="form-control form-control-sm"
                                                            wire:model.defer="ingreditenteDatos.{{ $item['id'] }}.cantidad" required>
                                                        @error('ingreditenteDatos.{{ $item["id"] }}.cantidad') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-control form-control-sm" wire:change='guardarCantidadUnidades({{$item["id"]}})'
                                                            wire:model.defer="ingreditenteDatos.{{ $item['id'] }}.unidades">
                                                            <option value="Opcional" selected disabled>Opcional</option>
                                                            <optgroup label="Liquidos">
                                                                <option value="litro">Litro (L)</option>
                                                                <option value="mililitro">Mililitro (ml)</option>
                                                            </optgroup>
                                                            <optgroup label="Peso/Masa">
                                                                <option value="kilo">Kilo</option>
                                                                <option value="kilogramo">Kilogramo (kg)</option>
                                                                <option value="gramo">Gramo (g)</option>
                                                                <option value="miligramo">Miligramo (mg)</option>
                                                            </optgroup>
                                                            <optgroup label="Unidades">
                                                                <option value="taza">Taza</option>
                                                                <option value="cucharada">Cucharada</option>
                                                                <option value="cucharadita">Cucharadita</option>
                                                                <option value="unidades">Unidades</option>
                                                                <option value="medias">Medias</option>
                                                                <option value="medianas">Medianas</option>
                                                            </optgroup>
                                                        </select>
                                                        @error('ingreditenteDatos.{{ $item["id"] }}.unidades') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <i class="bi bi-trash btn" wire:click="eliminarIngrediente({{ $item['id'] }})"></i>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <div class="form-group col-md-6">
                                    <label class="form-label"><span class="">Instrucciones</span> (Opcional)</label>
                                    @foreach ($pasos as $indice => $paso)
                                    <div class="d-flex align-items-center" wire:key='{{ $indice }}'>
                                        <textarea type="text" class="form-control"
                                            wire:model="pasos.{{ $indice }}.descripcion" placeholder="Nuevo el paso"></textarea>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <span class="badge bg-info rounded-pill">{{ $paso['numero'] }}</span>
                                            <i class="bi bi-trash" wire:click='eliminarPaso({{ $indice }})'></i>
                                        </div>
                                    </div>
                                    <hr>
                                    @endforeach
                                    <div>
                                        <a href="#" class="btn btn-sm btn-icon btn-ligth" wire:click.prevent="addPaso">
                                            <p class=""><i class="bi bi-plus-circle"></i> Añadir Paso</p>
                                        </a>
                                    </div>
                                    @error('pasoEdit.descripcion') <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                                    <a type="button" class="btn btn-danger btn-sm"
                                        onclick="window.history.back()">Salir</a>
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