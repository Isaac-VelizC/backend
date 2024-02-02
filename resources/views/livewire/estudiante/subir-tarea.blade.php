<div>
    <div class="iq-navbar-header" style="height: 80px;"></div> 
    <div class="conatiner-fluid content-inner mt-n5 py-0">
       <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <form class="needs-validation" novalidate wire:submit.prevent='updatedFiles'>
                                <div class="col-xl-12 col-lg-12">
                                    <div class="row">
                                        <div class="text-center">
                                            <h4>Formulario para subir Tarea</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <textarea class="form-control" wire:model='descripcion' placeholder="Descripción (Opcional)" rows="5">Editar</textarea>
                                                </div>

                                                <div
                                                    x-data="{ uploading: false, progress: 0 }"
                                                    x-on:livewire-upload-start="uploading = true"
                                                    x-on:livewire-upload-finish="uploading = false"
                                                    x-on:livewire-upload-error="uploading = false"
                                                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                                                >
                                                    <label class="upload-files">
                                                        <input class="file-upload" type="file" wire:model='files' multiple required>
                                                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                                            <path d="M10.409 0c4.857 0 3.335 8 3.335 8 3.009-.745 8.256-.419 8.256 3v11.515l-4.801-4.801c.507-.782.801-1.714.801-2.714 0-2.76-2.24-5-5-5s-5 2.24-5 5 2.24 5 5 5c1.037 
                                                                    0 2-.316 2.799-.858l4.858 4.858h-18.657v-24h8.409zm2.591 12c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3zm1.568-11.925c2.201 1.174 5.938 4.884 
                                                                    7.432 6.882-1.286-.9-4.044-1.657-6.091-1.18.222-1.468-.186-4.534-1.341-5.702z"/>
                                                        </svg>
                                                    </label>Subir Archivos
                                                    <!-- Progress Bar -->
                                                    <div x-show="uploading">
                                                        <progress max="100" x-bind:value="progress"></progress>
                                                    </div>
                                                    @error('files.*') <span class="error">{{ $message }}</span> @enderror
                                                </div>
                                                @if ($filesTarea)
                                                    @foreach ($filesTarea as $file)
                                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                                            <div class="ms-2 me-auto">
                                                                <div class="fw-bold">{{ $file->nombre }}</div>
                                                                {{$file->fecha}}
                                                            </div>
                                                            <span class="badge rounded-pill bg-light text-dark cursoMano" wire:click='eliminarFile({{$file->id}})'>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                                    <path d="M9 13v6c0 .552-.448 1-1 1s-1-.448-1-1v-6c0-.552.448-1 1-1s1 .448 1 1zm7-1c-.552 0-1 .448-1 1v6c0 .552.448 1 1 1s1-.448 1-1v-6c0-.552-.448-1-1-1zm-4 0c-.552 0-1 .448-1 1v6c0 .552.448 1 1 1s1-.448 1-1v-6c0-.552-.448-1-1-1zm4.333-8.623c-.882-.184-1.373-1.409-1.189-2.291l-5.203-1.086c-.184.883-1.123 1.81-2.004 1.625l-5.528-1.099-.409 1.958 19.591 4.099.409-1.958-5.667-1.248zm4.667 4.623v16h-18v-16h18zm-2 14v-12h-14v12h14z"/>
                                                                </svg>
                                                            </span>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="text-center">
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="window.history.back()">Cancelar</button>
                                            <button type="button" class="btn btn-secondary btn-sm" wire:click='enviarTarea()' >Enviar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </div>
</div>