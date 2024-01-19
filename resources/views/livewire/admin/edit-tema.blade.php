<div>
    <div class="iq-navbar-header" style="height: 150px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                        <div>
                          <h4>hldsa</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div> 
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        @if(session('error'))
            <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" novalidate wire:submit.prevent='actualizarTema'>
                            @csrf
                            <div class="modal-body text-black">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-12">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="form-label"><span class="text-danger">*</span> Titulo:</label>
                                                <input type="text" wire:model="editar.nombre" placeholder="Ingrese el titulo del tema" class="form-control" required>
                                                @error('editar.nombre')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"> Files:</label>
                                                <input type="file" class="form-control" wire:model="editar.file">
                                                @error('fecha')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Descripción: (Opcional) </label>
                                                <textarea class="form-control" wire:model.lazy="editar.descripcion" id="descripcionId"></textarea>
                                                @error('editar.descripcion')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a type="button" class="btn btn-secondary" href="{{ route('cursos.curso', $tema->curso_id) }}">Volver</a>
                                <button class="btn btn-danger" type="submit">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>    
    @section('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
        <script>
            document.addEventListener('livewire:load', function () {
                ClassicEditor
                    .create(document.querySelector('#descripcionId'))
                    .then(editor => {
                        editor.setData(@json($editar['descripcion']));
                        editor.model.document.on('change', () => {
                            @this.set('editar.descripcion', editor.getData());
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        </script>
        
    @endsection
</div>