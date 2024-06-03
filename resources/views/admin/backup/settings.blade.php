@extends('layouts.app')

@section('content')
<form action="{{ route('backup.saveSettings') }}" method="POST">
    @csrf
    <div>
        <label for="databases">Bases de datos:</label>
        <select name="databases[]" id="databases" multiple>
            <option value="mysql">MySQL</option>
            <!-- Agrega más opciones según sea necesario -->
        </select>
    </div>
    <div>
        <label for="files">Archivos/Directorios:</label>
        <input type="text" name="files[]" id="files" placeholder="/ruta/al/directorio" multiple>
    </div>
    <button type="submit">Guardar Configuración</button>
</form>

<form action="{{ route('backup.run') }}" method="POST">
    @csrf
    <button type="submit">Ejecutar Backup Ahora</button>
</form>


@endsection