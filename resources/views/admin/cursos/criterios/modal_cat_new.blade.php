<div class="modal fade" id="formCriterioCatNew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="formCriterioCatNewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Categorias del criterio </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate method="POST" action="{{ route('admin.store.cat.criterios') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <select class="form-select" name="criterio" required onchange="selectPonderacion(this.value)">
                                <option value="" disabled selected>Seleccionar un criterio</option>
                                @foreach ($criterios as $crit)
                                    <option value="{{ $crit->id }}">{{ $crit->nombre }}</option>
                                @endforeach
                            </select>
                            @error('criterio') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-lg-8">
                            <input type="text" class="form-control" name="nombre" placeholder="Ingrese un nombre">
                            @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" name="porcentajeCat" id="porcentajeCat" placeholder="%" oninput="restarPorcentajeCat()" pattern="\d*" required>
                            @error('porcentajeCat') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="numeric" class="form-control" name="totalPocentCategoria" id="totalPocentCategoria" required>
                            @error('totalPocentCategoria') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div id="alertCat" class="text-danger"></div>              
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" onclick="enablePonderacion()">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var ponderacion = 0;

    function selectPonderacion(id) {
        axios.get('/select/ponderacion/' + id)
            .then(function (response) {
                ponderacion = response.data.data;
                document.getElementById('totalPocentCategoria').value = response.data.data;
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    // Función para restar el porcentaje
    function restarPorcentajeCat() {
        var porcentaje = parseFloat(document.getElementById('porcentajeCat').value) || 0;
        var resultado = ponderacion - porcentaje;
        if (resultado >= 0) {
            document.getElementById('totalPocentCategoria').value = resultado;
            clearError(); // Limpiar cualquier mensaje de error
        } else {
            document.getElementById('porcentajeCat').value = '';
            var error = "El porcentaje no puede ser mayor que la ponderación.";
            showError(error); // Mostrar el mensaje de error
        }
    }

    // Funciones para mostrar y limpiar mensajes de error
    function showError(errorMessage) {
        document.getElementById('alertCat').innerText = errorMessage;
        document.getElementById('alertCat').style.display = 'block';
    }
    
    function clearError() {
        document.getElementById('alertCat').innerText = '';
        document.getElementById('alertCat').style.display = 'none';
    }

    // Función para habilitar el campo totalPocentCategoria
    function enablePonderacion() {
        document.getElementById('totalPocentCategoria').disabled = false;
        document.getElementById('ponderacion_hidden').value = document.getElementById('totalPocentCategoria').value;
    }
</script>
