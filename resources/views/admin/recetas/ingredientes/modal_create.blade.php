<div class="modal fade" id="formIngrediente" tabindex="-1" aria-labelledby="formIngrediente" aria-hidden="true">
    <div class="modal-dialog">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formIngrediente">Ingistrar nuevo ingrediente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('new.ingrediente.db') }}">
                @csrf
                <div class="modal-body">
                    <div class="col-sm-12 col-lg-12">
                        <div class="row">
                            <div class="form-group">
                                <label class="form-label" for="fname">Nombre del Ingrediente:</label>
                                <input type="text" class="form-control" id="fname" name="nombre" value="{{ old('nombre') }}" placeholder="Nombre" required>
                                @error('nombre')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="type_select">Seleccionar Tipo</label>
                                <select class="form-select" id="type_select" name="tipo" required>
                                  <option value="{{ old('tipo') }}" disabled selected>Seleccionar</option>
                                  @if ($types->count() > 0)
                                      @foreach ($types as $type)
                                          <option value="{{ $type->id }}">{{ $type->nombre }}</option>
                                      @endforeach
                                  @else
                                      <option value="">Vacio</option>
                                  @endif
                                </select>
                                @error('tipo')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-danger" type="submit">Guardar</button>
                </div>
            </form>
       </div>
    </div>
 </div>