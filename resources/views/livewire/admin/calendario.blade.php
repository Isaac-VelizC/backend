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
                        <option value="#0000FF">🔵 Azul</option>
                        <option value="#800080">🟣 Morado</option>
                        <option value="#FFA500">🟠 Naranja</option>
                        <option value="#FF0000">🔴 Rojo</option>
                        <option value="#008000">🟢 Verde</option>
                        <option value="#FFFF00">🟡 Amarillo</option>
                        <option value="#A52A2A">🟤 Marrón</option>
                    </select>
                    @error('eventos.backgroundColor') <span class="text-danger">{{ $message }}</span> @enderror
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
                <div class=" rounded-2 cursor-pointer overflow-x-scroll" wire:click='edit({{$item->id}})' style="margin-bottom: 5px; background-color: {{ $item->backgroundColor }};">
                    <span class=" px-2" style="color: {{$item->textColor}};">{{ $item->nombre }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
