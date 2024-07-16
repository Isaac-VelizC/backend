<div class="modal fade" id="editCurso{{$itemId}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="editCursoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCursoLabel">Modificar datos de la materia {{ $item->nombre }} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate method="POST"
                action="{{ route('admin.actualizar-curso', $itemId) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="form-label" for="fname">Nombre de Curso:</label>
                                            <input type="text" class="form-control" id="fname" name="nombre"
                                                value="{{ old('nombre', $item->nombre) }}" placeholder="Nombre"
                                                required>
                                            @error('nombre')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="descrip">Descripción</label>
                                            <textarea class="form-control" id="descrip" name="descripcion"
                                                rows="5">{{ old('descripcion', $item->descripcion) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="form-label" for="moduloSelect{{ $item->id }}">Seleccionar
                                                Semestre</label>
                                            <select class="form-select" id="moduloSelect{{ $item->id }}" name="semestre"
                                                required>
                                                <option value="" disabled selected>Seleccionar</option>
                                                @if ($modulos->count() > 0)
                                                @foreach ($modulos as $mod)
                                                <option value="{{ $mod->id }}" @if ($mod->id == $item->semestre_id)
                                                    selected @endif>{{ $mod->nombre }}</option>
                                                @endforeach
                                                @else
                                                <option value="">No Hay Sementres</option>
                                                @endif
                                            </select>
                                            @error('semestre')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @if ($item->dependencia != 0)
                                        @php
                                        $nom = app\Models\Materia::find($item->dependencia)->nombre;
                                        @endphp
                                        <small class="text-warning">La materia tiene dependencia de la materia {{ $nom }}</small>
                                        @endif
                                        <div class="form-group">
                                            <label class="form-label" for="dependenciaSelect{{ $item->id }}">Seleccionar
                                                Dependencia (Opcional)</label>
                                            <select class="form-select" id="dependenciaSelect{{ $item->id }}"
                                                name="dependencia">
                                                <option value="0" disabled selected>Seleccionar Curso</option>
                                                <option value="0">Ninguno</option>
                                            </select>
                                            @error('dependencia')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <input type="hidden" name="idItem" id="IdItem{{ $item->id }}"
                                            value="{{ $item->id }}">
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="exampleInputcolorSelect{{ $item->id }}">Color
                                                del Curso</label>
                                            <select class="form-select" id="exampleInputcolorSelect{{ $item->id }}" name="color" required>
                                                <option value="#FF5733" style="background: #FF5733" selected>#FF5733</option>
                                                <option value="#FF942F" style="background: #FF942F">#FF942F</option>
                                                <option value="#97FF2F" style="background: #97FF2F">#97FF2F</option>
                                                <option value="#FF2F91" style="background: #FF2F91">#FF2F91</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label">Tipo Materia</label>
                                            <select class="form-select" name="tipo" required>
                                                <option value="1" {{ $item->tipo == 1 ? 'selected' : '' }}>Practico</option>
                                                <option value="2" {{ $item->tipo == 2 ? 'selected' : '' }}>Teorico</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="colorLineEdit{{ $item->id }}" @if ($item)
                                        style="background: {{ $item->color }}; height: 6px" @else
                                        style="background: #FF2F91; height: 6px" @endif></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelButton"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('moduloSelect{{ $item->id }}').addEventListener('change', function() {
        var itemId = document.getElementById('IdItem{{ $item->id }}').value;
        var selectedSemestreId = this.value;
        axios.get('/ruta/al/servidor/para/obtener/cursos', {
            params: {
                semestreId: selectedSemestreId,
            }
        })
        .then(function(response) {
            var dependenciaSelect = document.getElementById('dependenciaSelect{{ $item->id }}');
            dependenciaSelect.innerHTML = '<option value="" disabled selected>Seleccionar</option><option value="0">Ninguno</option>';
            response.data.cursos.forEach(function(curso) {
                if (curso.id != itemId) {
                    var option = document.createElement('option');
                    option.value = curso.id;
                    option.textContent = curso.nombre;
                    dependenciaSelect.appendChild(option);
                }
            });
        })
        .catch(function(error) {
            console.error(error);
        });
    });
</script>
<script>
    document.getElementById('exampleInputcolorSelect{{$item->id}}').addEventListener('change', function() {
        var selectedColorEdit = this.value;
        document.getElementById('colorLineEdit{{ $item->id }}').style.background = selectedColorEdit;
    });
</script>