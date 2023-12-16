<div class="modal fade" id="ingedienteModal{{ $idModal }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ingedienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formIngrediente">{{ $item['nombre'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12 col-lg-12">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label text-black"><span class="text-danger">*</span> Cantidad</label>
                            <input type="text" class="form-control" wire:model="ingreditenteDatos.cantidad" required>
                            @error('ingreditenteDatos.cantidad') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label text-black"><span class="text-danger">*</span> Unidades</label>
                            <input type="text" class="form-control" wire:model="ingreditenteDatos.unidades" required>
                            @error('ingreditenteDatos.unidades') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>     
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" wire:click="guardarCantidadUnidades({{$idModal}})" data-bs-dismiss='modal'>Guardar</button>
            </div>
        </div>
    </div>
 </div>