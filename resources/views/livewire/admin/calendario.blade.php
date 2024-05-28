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
                    <label class="form-label">Color de Fondo: </label>
                    <select class="form-select" wire:model="eventos.backgroundColor" required>
                        <option style="color: #0000FF" value="#0000FF">Azul</option>
                        <option style="color: #FF0000" value="#FF0000">Rojo</option>
                        <option style="color: #00FF00" value="#00FF00">Verde</option>
                        <option style="color: #800080" value="#800080">Morado</option>
                        <option style="color: #FF6900" value="#FF6900">Naranja</option>
                        <option style="color: #FF00FF" value="#FF00FF">Magenta</option>
                    </select>
                    @error('eventos.backgroundColor') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                @if($modoEdicion)
                    <input type="hidden" wire:model="eventId">
                @endif
                <div class="text-center">
                    @if ($modoEdicion && $eventId != 1)
                        <button type="button" wire:click="eliminar" class="btn btn-danger" style="color: white">Borrar</button>
                    @endif
                    <button type="submit" class="btn btn-primary" style="color: white">{{ $modoEdicion ? 'Actualizar' : 'Guardar' }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header text-center">
            <div class="header-title">
                <h5 class="card-title">Tipos de Eventos</h5>
            </div>
            <small class="text-warning">Click para editar</small>
        </div>
        <div class="card-body">
            @foreach ($categorias as $item)
                <div class="rounded-2 overflow-x-scroll" wire:click='edit({{$item->id}})' style="cursor: pointer; margin-bottom: 5px; background-color: {{ $item->backgroundColor }};">
                    <span class=" px-2" style="color: {{$item->textColor}};">{{ $item->nombre }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
