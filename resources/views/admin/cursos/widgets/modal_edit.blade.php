<div class="modal fade" id="editCurso{{$itemId}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCursoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCursoLabel">Crear un nuevo curso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate method="POST" action="{{ route('admin.actualizar-curso', $itemId) }}">
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
                                        <input type="text" class="form-control" id="fname" name="nombre" value="{{ old('nombre', $item->nombre) }}" placeholder="Nombre" required>
                                          @error('nombre')
                                              <div class="alert alert-danger">{{ $message }}</div>
                                          @enderror
                                      </div>
                                      <div class="form-group">
                                        <label class="form-label" for="descrip">Descripción</label>
                                        <textarea class="form-control" id="descrip" name="descripcion" rows="3">{{ old('descripcion', $item->descripcion) }}</textarea>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                  <div class="row">
                                    <div class="form-group">
                                        <label class="form-label" for="modulo_select">Seleccionar Semestre</label>
                                        <select class="form-select" id="modulo_select" name="semestre" required>
                                          <option value="" disabled selected>Seleccionar</option>
                                          @if ($modulos->count() > 0)
                                              @foreach ($modulos as $mod)
                                                  <option value="{{ $mod->id }}" @if ($mod->id == $item->semestre_id) selected @endif>{{ $mod->nombre }}</option>
                                              @endforeach
                                          @else
                                              <option value="">No Hay Sementres</option>
                                          @endif
                                        </select>
                                        @error('semestre')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exampleInputcolorSelect">Color del Curso (Menú desplegable)</label>
                                        <select class="form-select" id="exampleInputcolorSelect" name="color" required>
                                            <option value="#0000FF" {{ $item->color == '#0000FF' ? 'selected' : '' }}>🔵 Azul</option>
                                            <option value="#800080" {{ $item->color == '#800080' ? 'selected' : '' }}>🟣 Morado</option>
                                            <option value="#FFA500" {{ $item->color == '#FFA500' ? 'selected' : '' }}>🟠 Naranja</option>
                                            <option value="#FF0000" {{ $item->color == '#FF0000' ? 'selected' : '' }}>🔴 Rojo</option>
                                            <option value="#008000" {{ $item->color == '#008000' ? 'selected' : '' }}>🟢 Verde</option>
                                            <option value="#FFFF00" {{ $item->color == '#FFFF00' ? 'selected' : '' }}>🟡 Amarillo</option>
                                            <option value="#A52A2A" {{ $item->color == '#A52A2A' ? 'selected' : '' }}>🟤 Marrón</option>
                                        </select>
                                    </div>
                                  </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelButton" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>