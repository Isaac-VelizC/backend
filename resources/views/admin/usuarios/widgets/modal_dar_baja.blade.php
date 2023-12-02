<div class="modal fade" id="deleteConfirm{{ $modalId }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{$item->estado ? 'Confirmo Dar de Baja' : 'Confirmo Dar de Alta' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{$item->estado ? '¿Estás seguro de dar de baja al usuario?' : '¿Estás seguro de dar de alta al usuario?' }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" action="{{ route('admin.' . $tipo . '.gestionarEstado', [$id, $item->estado ? 'baja' : 'alta']) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{$item->estado ? 'Confirmo Dar de Baja' : 'Confirmo Dar de Alta' }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
