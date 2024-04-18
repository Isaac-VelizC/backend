<div class="modal fade" id="formCriterioNew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="formCriterioNewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formCriterioNewLabel">Nuevo Criterio </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate method="POST" action="{{ route('admin.store.criterios') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-8">
                            <input type="text" class="form-control" name="nombre" placeholder="Ingresa un nombre">
                            @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" name="porcentaje" id="porcentajeCrit" placeholder="%" oninput="restarPorcentaje()" pattern="\d*" required>
                            @error('porcentaje')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="numeric" class="form-control" name="ponderacion" id="ponderacion" value="{{ $ponderacion }}" disabled>
                            <input type="hidden" name="ponderacion_hidden" id="ponderacion_hiddenCriterio">
                        </div>
                    </div>
                    <div id="alert" class="text-danger"></div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" onclick="enablePonderacionCrit()">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var ponderacionOriginal = parseFloat(document.getElementById('ponderacion').value) || 0;
    
    function restarPorcentaje() {
        var porcentaje = parseFloat(document.getElementById('porcentajeCrit').value) || 0;
        var ponderacion = ponderacionOriginal; // Usar el valor original de la ponderación
        var resultado = ponderacion - porcentaje;
        if (resultado >= 0) {
            document.getElementById('ponderacion').value = resultado;
            clearErrorCrit(); // Llamar a la función para limpiar el mensaje de error
        } else {
            document.getElementById('porcentajeCrit').value = '';
            var error = "El porcentaje no puede ser mayor que la ponderación.";
            showErrorCrit(error); // Llamar a la función para mostrar el mensaje de error
        }
    }
    
    function showErrorCrit(errorMessage) {
        document.getElementById('alert').innerText = errorMessage;
        document.getElementById('alert').style.display = 'block';
    }
    
    function clearErrorCrit() {
        document.getElementById('alert').innerText = '';
        document.getElementById('alert').style.display = 'none';
    }

    function enablePonderacionCrit() {
        document.getElementById('ponderacion').disabled = false;
        document.getElementById('ponderacion_hiddenCriterio').value = document.getElementById('ponderacion').value;
    }
</script>
