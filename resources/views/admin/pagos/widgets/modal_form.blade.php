<div class="modal fade" id="formPago{{$id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulario de Pago {{ $met->nombre }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-black">
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <form >
                            @csrf
                                <div class="col-sm-12 col-lg-12">
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <p>Se esta registrando el pago del estudiante 
                                                <span class="text-secondary">
                                                    {{ $estudiante->persona->nombre }} {{ $estudiante->persona->ap_paterno }} {{ $estudiante->persona->ap_materno }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label class="form-label"><span class="text-danger">*</span> Fecha:</label>
                                            <input type="date" class="form-control" name="fecha" value="{{ now()->toDateString() }}" required>
                                            @error('fecha')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label class="form-label"><span class="text-danger">*</span> Monto:</label>
                                            <input type="number" step="0.01" class="form-control" name="monto" value="{{ old('monto') }}" placeholder="Bs." required>
                                            @error('monto')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>                            
                                        <div class="form-group col-lg-12">
                                            <label class="form-label">Descripción: (Opcional) </label>
                                            <textarea type="text" class="form-control" name="descripcion" placeholder="Escribe una breve descripción" required></textarea>
                                            @error('descripcion')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                        </form>
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
                        <li><a class="dropdown-item" wire:click='guardarImprimir'>Guardar e Imprimir</a></li>
                    </ul>
                </div>
            </div>
       </div>
    </div>
 </div>
 