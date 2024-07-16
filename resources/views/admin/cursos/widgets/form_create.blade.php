<div class="modal fade" id="newCurso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newCursoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCursoLabel">Registrar uno nuevo</h5>
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
                                        <label class="form-label" for="fname">Nombre de Materia:</label>
                                        <input type="text" class="form-control" id="fname" name="nombre" placeholder="Nombre" required>
                                          @error('nombre')
                                              <div class="alert alert-danger">{{ $message }}</div>
                                          @enderror
                                      </div>
                                      <div class="form-group">
                                        <label class="form-label" for="descrip">Descripción</label>
                                        <textarea class="form-control" id="descrip" name="descripcion" rows="5" placeholder="Descripcion de la materia (Opcional)"></textarea>
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
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="exampleInputcolor">Color de la materia</label>
                                        <select class="form-select" id="exampleInputcolor" name="color" required>
                                            <option value="#FF5733" style="background: #FF5733" selected>#FF5733</option>
                                            <option value="#FF942F" style="background: #FF942F">#FF942F</option>
                                            <option value="#97FF2F" style="background: #97FF2F">#97FF2F</option>
                                            <option value="#FF2F91" style="background: #FF2F91">#FF2F91</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Tipo Materia</label>
                                        <select class="form-select" name="tipo" required>
                                            <option value="1" selected>Practico</option>
                                            <option value="2">Teorico</option>
                                        </select>
                                    </div>
                                  </div>
                              </div>
                            </div>
                            <div id="colorLine" style="background: #FF5733; height: 6px"></div>
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
        var selectedSemestreId = this.value;
        axios.get('/ruta/al/servidor/para/obtener/cursos', {
            params: {
                semestreId: selectedSemestreId,
            }
        })
        .then(function(response) {
            var dependenciaSelect = document.getElementById('dependencia_select');
            dependenciaSelect.innerHTML = '<option value="" disabled selected>Seleccionar</option><option value="0">Ninguno</option>';
            
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
<script>
    document.getElementById('exampleInputcolor').addEventListener('change', function() {
        var selectedColor = this.value;
        document.getElementById('colorLine').style.background = selectedColor;
    });
</script>
