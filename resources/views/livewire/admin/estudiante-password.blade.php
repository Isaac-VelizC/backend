<div>
    @if(session('confirm'))
       <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
           <span>{{ session('confirm') }}</span>
           <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
       </div>
   @endif
    <form wire:submit.prevent='cambiarPassword'>
        @csrf
        <div class="form-group">
            <label class="form-label">Contraseña: *</label>
            <input type="password" class="form-control" wire:model="pass" placeholder="***********" required>
            @error('pass') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label class="form-label">Confirmar Contraseña: *</label>
            <input type="password" class="form-control" wire:model="passConfirm" placeholder="***********" required>
            @error('passConfirm') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
    </form>
</div>
