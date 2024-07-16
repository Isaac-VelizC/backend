<div class="card">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card-body">
                <form wire:submit.prevent='updatedFiles' enctype="multipart/form-data">
                    <div
                        x-data="{ uploading: false, progress: 0 }"
                        x-on:livewire-upload-start="uploading = true"
                        x-on:livewire-upload-finish="uploading = false"
                        x-on:livewire-upload-error="uploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                    >
                        <label class="upload-files btn btn-sm btn-light">
                            <input class="file-upload" type="file" wire:model='files' multiple>
                            <i class="bi bi-files"></i> Subir Archivos
                        </label>
                        <!-- Progress Bar -->
                        <div x-show="uploading">
                            <progress max="100" x-bind:value="progress"></progress>
                        </div>
                        @error('files.*') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </form>
                <hr>
                @if (count($filesCurso) > 0)
                    @foreach ($filesCurso as $file)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <a href="{{ asset($file->url) }}">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">{{ $file->nombre }}</div>
                                </div>
                            </a>
                            @if ($materia->estado == 1)
                                <span class="btn text-black cursoMano" wire:click='eliminarFile({{$file->id}})'>
                                    <i class="bi bi-trash"></i>
                                </span>
                            @else
                                <div></div>
                            @endif
                        </li>
                    @endforeach
                @else
                    <div class="text-center">
                        <p>No hay archivos publicados aun</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>