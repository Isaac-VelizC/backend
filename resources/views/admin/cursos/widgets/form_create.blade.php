<div class="modal fade" id="newCurso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newCursoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCursoLabel">Crear un nuevo curso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate method="POST" action="{{ route('admin.guardar-curso') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <div class="row">
                                      <div class="form-group">
                                        <label class="form-label" for="fname">Nombre de Curso:</label>
                                        <input type="text" class="form-control" id="fname" name="nombre" placeholder="Nombre" required>
                                          @error('nombre')
                                              <div class="alert alert-danger">{{ $message }}</div>
                                          @enderror
                                      </div>
                                      <div class="form-group">
                                        <label class="form-label" for="descrip">Descripción</label>
                                        <textarea class="form-control" id="descrip" name="descripcion" rows="5"></textarea>
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
                                                  <option value="{{ $mod->id }}">{{ $mod->nombre }}</option>
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
                                          <option value="" disabled selected>Seleccionar</option>
                                        </select>
                                        @error('dependencia')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exampleInputcolor">Color del Curso</label>
                                        <select class="form-select" id="exampleInputcolor" name="color" required>
                                            <option value="#0000FF" selected>🔵 Azul</option>
                                            <option value="#800080">🟣 Morado</option>
                                            <option value="#FFA500">🟠 Naranja</option>
                                            <option value="#FF0000">🔴 Rojo</option>
                                            <option value="#008000">🟢 Verde</option>
                                            <option value="#FFFF00">🟡 Amarillo</option>
                                            <option value="#A52A2A">🟤 Marrón</option>
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
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('modulo_select').addEventListener('change', function() {
        console.log('hola');
        var selectedSemestreId = this.value;
        axios.get('/ruta/al/servidor/para/obtener/cursos', {
            params: {
                semestreId: selectedSemestreId,
            }
        })
        .then(function(response) {
            var dependenciaSelect = document.getElementById('dependencia_select');
            dependenciaSelect.innerHTML = '<option value="" disabled selected>Seleccionar</option>';
            
            response.data.cursos.forEach(function(curso) {
                var option = document.createElement('option');
                option.value = curso.id;
                option.textContent = curso.nombre;
                dependenciaSelect.appendChild(option);
            });
        })
        .catch(function(error) {
            console.error(error);
        });
    });
</script>