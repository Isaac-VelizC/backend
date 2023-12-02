<div class="modal fade" id="deleteConfirm{{ $itemId }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
       <div class="modal-content">
          <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{$item->estado ? 'Confirmo Dar de Baja' : 'Confirmo Dar de Alta' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            {{$item->estado ? '¿Estás seguro de dar de baja la materia?' : '¿Estás seguro de dar de alta la materia?' }}
             </div>
             <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                   <form method="POST" action="{{ route('admin.cursos.' . ($item->estado ? 'darBaja' : 'darAlta'), [$itemId]) }}">
                        @csrf
                        @method('DELETE')
                        <div class="btn-group">
                            <button class="btn btn-danger" type="submit">{{$item->estado ? 'Dar de Baja' : 'Dar de Alta' }}</button>
                            <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ Route('admin.cursos.delete', [$itemId]) }}">Eliminar</a></li>
                            </ul>
                        </div>
                   </form>
             </div>
       </div>
    </div>
 </div>