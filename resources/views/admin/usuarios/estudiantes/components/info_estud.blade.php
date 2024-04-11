<div class="card-header d-flex justify-content-between">
    <div class="header-title">
        <h4 class="card-title">Informacion del Estudiante</h4>
    </div>
</div>
<div class="card-body">
    <div class="new-user-info">
        <form class="needs-validation" novalidate method="POST" id="formHabilitarDesabilitar" action="{{ route('update.estudiantes', $est->id) }}">
        @csrf
        @method('PUT')
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="form-label" for="fname">Nombre del estudiante: *</label>
                    <input type="text" class="form-control" id="fname" name="nombre" value="{{ $estudiante->nombre }}" placeholder="Nombre" required>
                </div>
                @error('nombre')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group col-md-4">
                    <label class="form-label" for="ap_pat">Primer Apellido:</label>
                    <input type="text" class="form-control" id="ap_pat" name="ap_pat" value="{{ $estudiante->ap_paterno }}" placeholder="Apellido Paterno">
                </div>
                @error('ap_pat')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group col-md-4">
                    <label class="form-label" for="ap_mat">Segundo Apellido:</label>
                    <input type="text" class="form-control" id="ap_mat" name="ap_mat" value="{{ $estudiante->ap_materno }}" placeholder="Apellido Materno">
                </div>
                @error('ap_mat')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group col-md-4">
                    <label class="form-label" for="ci">Cedula de Identidad: *</label>
                    <input type="text" class="form-control" id="ci" name="ci" value="{{ old('ci', $estudiante->ci ) }}" placeholder="Cedula de Identidad" required>
                </div>
                @error('ci')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group col-sm-4">
                    <label class="form-label">Genero: *</label>
                    <select name="genero" class="selectpicker form-control" data-style="py-0" id="generoSelect" required>
                        <option>Seleccionar</option>
                        <option value="Hombre" {{ old('genero', $estudiante->genero == 'Hombre' ? 'selected' : '') }}>Hombre</option>
                        <option value="Mujer" {{ old('genero', $estudiante->genero == 'Mujer' ? 'selected' : '') }}>Mujer</option>
                        <option value="Otro" {{ old('genero', $estudiante->genero == 'Otro' ? 'selected' : '') }}>Otro</option>
                    </select>
                </div>
                @error('genero')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group col-md-4">
                    <label class="form-label" for="mobno">Numero Celular: *</label>
                    <input type="text" class="form-control" id="mobno" name="telefono" value="{{ old('telefono',  $estudiante->numero) }}" placeholder="Numero de Celular" required>
                </div>
                @error('telefono')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group col-md-4">
                    <label class="form-label" for="email">E mail: *</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email',  $estudiante->email) }}" placeholder="E mail" required>
                </div>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group col-md-4">
                    <label class="form-label" for="fnac">Fecha Nacimiento: *</label>
                    <input type="date" class="form-control" id="fnac" name="fnac" value="{{ old('fnac', $est->fecha_nacimiento ) }}" required>
                </div>
                @error('fnac')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group col-md-4">
                    <label class="form-label" for="direccion">Dirección: *</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion', $est->direccion ) }}" placeholder="Dirección" required>
                </div>
                @error('direccion')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group col-md-4">
                    <label class="form-label">Horario *</label>
                    <select class="selectpicker form-control" data-style="py-0" id="generoSelect" name="horario" required>
                      <option value="" disabled selected>Seleccionar</option>
                        @if ($horarios->count() > 0)
                            @foreach ($horarios as $mod)
                                <option value="{{ $mod->id }}" {{ $mod->id == $est->turnos->id ? 'selected' : '' }}>{{ $mod->turno }}</option>
                            @endforeach
                        @else
                            <option value="">No Hay Sementres</option>
                        @endif
                    </select>
                    @error('horario')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <hr>
            <div class="col-6">
                <button type="submit" class="btn btn-success">Actualizar</button>
            </div>
        </form>
    </div>
</div>