<div>
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
          <h4 class="card-title">Informacion del Contacto</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="new-user-info">
            <form wire:submit.prevent="update" class="needs-validation" novalidate>
            @csrf
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="form-label">Nombre del Familiar: *</label>
                        <input type="text" class="form-control" wire:model="contactoEdit.nombre" placeholder="Nombre" required>
                        @error('contactoEdit.nombre') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Primer Apellido:</label>
                        <input type="text" class="form-control" wire:model="contactoEdit.paterno" placeholder="Apellido Paterno">
                        @error('contactoEdit.paterno') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Segundo Apellido:</label>
                        <input type="text" class="form-control" wire:model="contactoEdit.materno" placeholder="Apellido Materno">
                        @error('contactoEdit.materno') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="ci">Cedula de Identidad: *</label>
                        <input type="text" class="form-control" wire:model="contactoEdit.cedula" placeholder="Cedula de Identidad" required>
                        @error('contactoEdit.cedula') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="form-label">Genero: *</label>
                        <select class="selectpicker form-control" wire:model="contactoEdit.genero" required>
                            <option selected>Seleccionar Genero</option>
                            <option value="Hombre">Hombre</option>
                            <option value="Mujer">Mujer</option>
                        </select>
                        @error('contactoEdit.genero') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="mobno">Numero Celular: *</label>
                        <input type="text" class="form-control" wire:model="contactoEdit.celular" placeholder="Numero de Celular" required>
                        @error('contactoEdit.celular') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="email">E mail:</label>
                        <input type="email" class="form-control" wire:model="contactoEdit.email" placeholder="E mail">
                        @error('contactoEdit.email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-success">Guardar</button>
                <button wire:click="edit()" type="button" class="btn btn-danger" >Cancelar</button>
            </form>
        </div>
    </div>
</div>
