<div>
    @if (session()->has('message'))
        <div class="alert alert-danger">
            {{ session('message') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="text-center">
                <div class="header-title">
                    <h4 class="card-title">Agregar Nuevo</h4>
                </div>
            </div>
            <form wire:submit.prevent='{{ $modoEdicion ? 'update' : 'store' }}'>
                @csrf
                <div class="form-group">
                    <label class="form-label">Nombre:</label>
                    <input type="nombre" class="form-control" wire:model="eventos.nombre">
                    @error('eventos.nombre') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Color de Fondo:</label>
                    <input type="color" class="form-control" wire:model="eventos.backgroundColor" required>
                    @error('eventos.backgroundColor') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Color de Texto:</label>
                    <input type="color" class="form-control" wire:model="eventos.textColor">
                    @error('eventos.textColor') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                @if($modoEdicion)
                    <input type="hidden" wire:model="eventId">
                @endif
                <div class="text-center">
                    @if ($modoEdicion)
                        <a wire:click="eliminar" class="h3 badge bg-danger" style="color: white" href="">Borrar</a>
                    @endif
                    <button type="submit" class="h3 badge bg-primary" style="color: white">{{ $modoEdicion ? 'Actualizar' : 'Guardar' }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header text-center">
            <div class="header-title">
                <h4 class="card-title">Tipos de Eventos</h4>
            </div>
        </div>
        <div class="card-body">
            @foreach ($categorias as $item)
                <div class="fc-event" wire:click='edit({{$item->id}})' style="margin-bottom: 5px;background-color: {{ $item->backgroundColor }};">
                    <span class="marquee-text tipoEvento" style="color: {{$item->textColor}};">{{ $item->nombre }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
