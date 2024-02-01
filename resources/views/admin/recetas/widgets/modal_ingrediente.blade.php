<div class="modal fade" id="ingedienteModal{{ $idModal }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ingedienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formIngrediente">{{ $item['nombre'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12 col-lg-12">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label text-black"><span class="text-danger">*</span> Cantidad</label>
                            <input type="text" class="form-control" wire:model="ingreditenteDatos.cantidad" required>
                            @error('ingreditenteDatos.cantidad') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label text-black"><span class="text-danger">*</span> Unidades</label>
                            <!--input type="text" class="form-control" wire:model="ingreditenteDatos.unidades" required-->
                            <select class="form-control" wire:model="ingreditenteDatos.unidades" required>
                                <option value="Opcional" selected>Opcional</option>
                                <!-- Volumen -->
                                <optgroup label="Volumen">
                                    <option value="metroCubico">Metro cúbico (m³)</option>
                                    <option value="litro">Litro (L)</option>
                                    <option value="mililitro">Mililitro (ml)</option>
                                    <option value="centimetroCubico">Centímetro cúbico (cm³)</option>
                                </optgroup>
                            
                                <!-- Peso/Masa -->
                                <optgroup label="Peso/Masa">
                                    <option value="kilo">Kilo</option>
                                    <option value="kilogramo">Kilogramo (kg)</option>
                                    <option value="gramo">Gramo (g)</option>
                                    <option value="miligramo">Miligramo (mg)</option>
                                    <option value="toneladaMetrica">Tonelada métrica (t)</option>
                                </optgroup>
        
                                <!-- Volumen (Cocina) -->
                                <optgroup label="Volumen (Cocina)">
                                    <option value="taza">Taza</option>
                                    <option value="cucharada">Cucharada</option>
                                    <option value="cucharadita">Cucharadita</option>
                                    <option value="litroCocina">Litro (L)</option>
                                    <option value="mililitroCocina">Mililitro (ml)</option>
                                    <option value="unidades">Unidades</option>
                                    <option value="medias">Medias</option>
                                    <option value="medianas">Medianas</option>
                                </optgroup>
                            </select>
                            @error('ingreditenteDatos.unidades') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" wire:click="guardarCantidadUnidades({{$idModal}})" data-bs-dismiss='modal'>Guardar</button>
            </div>
        </div>
    </div>
 </div>