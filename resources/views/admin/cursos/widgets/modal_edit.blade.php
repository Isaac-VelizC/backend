<div class="modal fade" id="editCurso{{$itemId}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCursoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCursoLabel">Modificar datos de la materia {{ $item->nombre }} </h5>
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
                                        <textarea class="form-control" id="descrip" name="descripcion" rows="5">{{ old('descripcion', $item->descripcion) }}</textarea>
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
                                        <label class="form-label" for="dependencia_select">Seleccionar Dependencia (Opcional)</label>
                                        <select class="form-select" id="dependencia_select" name="dependencia">
                                          <option value="0" disabled selected>Seleccionar Curso</option>
                                          <option value="0">Ninguno</option>
                                          <@if ($cursos->count() > 0)
                                              @foreach ($cursos as $curso)
                                                  <option value="{{ $curso->id }}" @if ($curso->id == $item->dependencia) selected @endif>{{ $curso->nombre }}</option>
                                              @endforeach
                                          @else
                                              <option value="">No Hay Cursos</option>
                                          @endif>
                                        </select>
                                        @error('dependencia')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exampleInputcolorSelect">Color del Curso</label>
                                        <select class="form-select" id="exampleInputcolorSelect" name="color" required>
                                            <option value="#FF5733" {{ $item->color == '#FF5733' ? 'selected' : '' }} style="background: #FF5733" selected>#FF5733</option>
                                            <option value="#FF942F" {{ $item->color == '#FF942F' ? 'selected' : '' }} style="background: #FF942F">#FF942F</option>
                                            <option value="#97FF2F" {{ $item->color == '#97FF2F' ? 'selected' : '' }} style="background: #97FF2F">#97FF2F</option>
                                            <option value="#2FFF77" {{ $item->color == '#2FFF77' ? 'selected' : '' }} style="background: #2FFF77">#2FFF77</option>
                                            <option value="#2FFFC6" {{ $item->color == '#2FFFC6' ? 'selected' : '' }} style="background: #2FFFC6">#2FFFC6</option>
                                            <option value="#2FC3FF" {{ $item->color == '#2FC3FF' ? 'selected' : '' }} style="background: #2FC3FF">#2FC3FF</option>
                                            <option value="#8A2FFF" {{ $item->color == '#8A2FFF' ? 'selected' : '' }} style="background: #8A2FFF">#8A2FFF</option>
                                            <option value="#DF2FFF" {{ $item->color == '#DF2FFF' ? 'selected' : '' }} style="background: #DF2FFF">#DF2FFF</option>
                                            <option value="#FF2F91" {{ $item->color == '#FF2F91' ? 'selected' : '' }} style="background: #FF2F91">#FF2F91</option>
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
