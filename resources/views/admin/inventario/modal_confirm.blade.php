<div class="modal fade" id="deleteConfirm{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar o dar de {{$item->estado == 'No disponible' ? 'Alta' : ($item->estado == 'Disponible' ? 'Baja' : '') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Estás seguro de eliminar o dar de  {{$item->estado == 'No disponible' ? 'Alta' : ($item->estado == 'Disponible' ? 'Baja' : '') }}
           </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <div class="btn-group">
                    <form method="POST" action="{{ route('admin.gestion.inventario.estado', $item->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit" data-bs-dismiss="modal">Dar de {{$item->estado == 'No disponible' ? 'Alta' : ($item->estado == 'Disponible' ? 'Baja' : '') }}</button>
                        <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.gestion.inventario.borrar', $item->id) }}">Eliminar</a></li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addCantidad{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Cantidad de {{ $item->ingrediente->nombre }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate method="POST" action="{{ route('admin.inventario.update.cantidad', $item->id) }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                            <p>La cantidad actual es de <b>{{ $item->cantidad }}</b></p>
                            <div class="form-group">
                                <label class="form-label"><span class="text-danger">*</span> Cantidad:</label>
                                <input type="number" class="form-control" name="cantidad" required>
                                @error('cantidad')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
