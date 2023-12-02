<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Formulario del {{ $formType ? 'Docente' : 'Personal' }} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate method="POST" action="{{ $formType ? route('store.docentes') : route('admin.personal.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="fname">Nombre de docente:</label>
                                    <input type="text" class="form-control" id="fname" name="nombre" value="{{ old('nombre') }}" placeholder="Nombre" required>
                                    @error('nombre')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="ap_pat">Apellido Paterno:</label>
                                    <input type="text" class="form-control" id="ap_pat" name="ap_pat" value="{{ old('ap_pat') }}" placeholder="Apellido Paterno">
                                    @error('ap_pat')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="ap_mat">Apellido Materno:</label>
                                    <input type="text" class="form-control" id="ap_mat" name="ap_mat" value="{{ old('ap_mat') }}" placeholder="Apellido Materno">
                                    @error('ap_mat')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="ci">Cedula de Identidad:</label>
                                    <input type="text" class="form-control" id="ci" name="ci" value="{{ old('ci') }}" placeholder="Cedula de Identidad" required>
                                    @error('ci')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">Genero:</label>
                                    <select name="genero" class="selectpicker form-control" data-style="py-0" required>
                                        <option value="" selected>Seleccionar</option>
                                        <option value="Hombre" {{ old('Hombre') }}>Hombre</option>
                                        <option value="Mujer" {{ old('Mujer') }}>Mujer</option>
                                    </select>
                                    @error('genero')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="mobno">Numero Celular:</label>
                                    <input type="text" class="form-control" id="mobno" name="telefono" value="{{ old('telefono') }}" placeholder="Numero de Celular">
                                    @error('telefono')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="email">E mail:</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="E mail" required>
                                    @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if (!$formType)                    
                                    <div class="form-group col-md-12">
                                        <label class="form-label" for="rol">Rol:</label>
                                        <input type="number" class="form-control" id="rol" name="rol" value="{{ old('rol') }}">
                                        @error('rol')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
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
    var image = document.getElementById('img')
    var input = document.getElementById('customFile')
    input.addEventListener('change', (e) => {
        image.src = URL.createObjectURL(e.target.files[0]);
    });

    document.getElementById('cancelButton').addEventListener('click', function () {
        var form = document.querySelector('form.needs-validation');
        var inputElements = form.querySelectorAll('input, select');
        inputElements.forEach(function (element) {
            if (element.tagName === 'SELECT') {
                element.value = 'Seleccionar Genero';
            } else {
                element.value = '';
            }
        });
    });
</script>