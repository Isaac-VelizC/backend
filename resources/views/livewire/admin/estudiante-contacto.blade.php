<div>
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
          <h4 class="card-title">Informacion del Contacto</h4>
        </div>
    </div>
    @if(session('error'))
        <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('success'))
        <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card-body">
        <div class="new-user-info">
            <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}" class="needs-validation" novalidate>
            @csrf
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="form-label">Nombre del Familiar: *</label>
                        <input type="text" class="form-control" wire:model="contactoEdit.nombre" placeholder="Nombre" required>
                        <span class="text-danger">{{ $errors->first('contactoEdit.nombre') }}</span>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Primer Apellido:</label>
                        <input type="text" class="form-control" wire:model="contactoEdit.paterno" placeholder="Apellido Paterno">
                        <span class="text-danger">{{ $errors->first('contactoEdit.paterno') }}</span>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Segundo Apellido:</label>
                        <input type="text" class="form-control" wire:model="contactoEdit.materno" placeholder="Apellido Materno">
                        <span class="text-danger">{{ $errors->first('contactoEdit.materno') }}</span>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="ci">Cedula de Identidad: *</label>
                        <input type="text" class="form-control" wire:model="contactoEdit.cedula" placeholder="Cedula de Identidad" required>
                        <span class="text-danger">{{ $errors->first('contactoEdit.cedula') }}</span>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="form-label">Genero: *</label>
                        <select class="selectpicker form-control" wire:model="contactoEdit.genero" required>
                            <option selected>Seleccionar Genero</option>
                            <option value="Hombre">Hombre</option>
                            <option value="Mujer">Mujer</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <span class="text-danger">{{ $errors->first('contactoEdit.genero') }}</span>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="mobno">Numero Celular: *</label>
                        <input type="text" class="form-control" wire:model="contactoEdit.celular" placeholder="Numero de Celular" required>
                        <span class="text-danger">{{ $errors->first('contactoEdit.celular') }}</span>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="email">E mail:</label>
                        <input type="email" class="form-control" wire:model="contactoEdit.email" placeholder="E mail">
                        <span class="text-danger">{{ $errors->first('contactoEdit.email') }}</span>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-success">Guardar</button>
                <button wire:click="edit()" type="button" class="btn btn-danger" >Cancelar</button>
            </form>
        </div>
    </div>
</div>
