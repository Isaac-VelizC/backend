<div class="modal fade" id="formPago" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar pago del {{ $tituloFormPago ?: null }} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate wire:submit.prevent='guardarPago'>
                @csrf
                <div class="modal-body text-black">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                                <div class="col-sm-12 col-lg-12">
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <p>Se esta registrando el pago del estudiante 
                                                <span class="text-secondary">
                                                    {{ $estudiante->persona->nombre }} {{ $estudiante->persona->ap_paterno }} {{ $estudiante->persona->ap_materno }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label class="form-label"><span class="text-danger">*</span> Forma de pago:</label>
                                            <select wire:model="pagosEdit.formaPago" class="form-select" required>
                                                <option value="" disabled>Seleccionar</option>
                                                @foreach ($formaPagos as $forma)
                                                    <option value="{{ $forma->id }}">{{ $forma->nombre }}</option>
                                                @endforeach
                                            </select>
                                            @error('fecha')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label class="form-label"><span class="text-danger">*</span> Fecha:</label>
                                            <input type="date" class="form-control" wire:model="pagosEdit.fecha" required>
                                            @error('fecha')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label class="form-label"><span class="text-danger">*</span> Monto:</label>
                                            <input type="number" step="0.01" class="form-control" wire:model='pagosEdit.monto' placeholder="Bs." required disabled>
                                            @error('monto')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>                            
                                        <div class="form-group col-lg-12">
                                            <label class="form-label">Descripción: (Opcional) </label>
                                            <textarea type="text" class="form-control" wire:model="pagosEdit.descripcion" placeholder="Escribe una breve descripción" required></textarea>
                                            @error('descripcion')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <div class="btn-group">
                        <button class="btn btn-danger" type="submit" data-bs-dismiss="modal">Guardar</button>
                        <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" wire:click='guardarImprimir'>Guardar e Imprimir</a></li>
                        </ul>
                    </div>
                </div>
            </form>
       </div>
    </div>
 </div>
 