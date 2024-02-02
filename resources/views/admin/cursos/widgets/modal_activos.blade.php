<div class="modal fade" id="estadoConfirm{{ $itemId }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
       <div class="modal-content">
          <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{$item->estado ? 'Confirmo Cerrar Materia' : 'Confirmo Dar de Alta' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            {{$item->estado ? '¿Estás seguro de cerrar la materia?' : '¿Estás seguro de dar de alta la materia?' }}
             </div>
             <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                   <form method="POST" action="{{ route('admin.cursos.cambiarEstado', [$itemId]) }}">
                        @csrf
                        <input type="hidden" name="estado" value="{{$item->estado ? 0 : 1 }}">
                        <div class="btn-group">
                            <button class="btn btn-danger" type="submit">{{$item->estado ? 'Cerrar Materia' : 'Dar de Alta' }}</button>
                            <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            @if ($item->fecha_ini > \Carbon\Carbon::now())
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ Route('admin.borrar.curso.activo', [$itemId]) }}">Eliminar</a></li>
                                </ul>
                            @endif
                        </div>
                   </form>
             </div>
       </div>
    </div>
 </div>
