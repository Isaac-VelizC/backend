<div class="modal fade" id="formPago" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulario de Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.pago.guardar') }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="col-sm-12 col-lg-12">
                        <div class="row">
                            <div class="form-group">
                                <label class="form-label" for="fname">Nombre de docente:</label>
                                <input type="text" class="form-control" id="fname" name="nombre" value="{{ old('nombre') }}" placeholder="Nombre" required>
                                @error('nombre')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="ap_pat">Apellido Paterno:</label>
                                <input type="text" class="form-control" id="ap_pat" name="ap_pat" value="{{ old('ap_pat') }}" placeholder="Apellido Paterno">
                                @error('ap_pat')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="ap_mat">Apellido Materno:</label>
                                <input type="text" class="form-control" id="ap_mat" name="ap_mat" value="{{ old('ap_mat') }}" placeholder="Apellido Materno">
                                @error('ap_mat')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="ci">Cedula de Identidad:</label>
                                <textarea type="text" class="form-control" id="ci" name="ci" value="{{ old('ci') }}" placeholder="Cedula de Identidad" required></textarea>
                                @error('ci')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <div class="btn-group">
                        <button class="btn btn-danger" type="submit">Guardar</button>
                        <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ Route('admin.pago.guardar.imprimir') }}">Guardar e Imprimir</a></li>
                        </ul>
                    </div>
                </div>
            </form>
       </div>
    </div>
 </div>