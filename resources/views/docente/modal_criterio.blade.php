<div class="modal fade" id="confirCriterio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirCriterioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirCriterioLabel">{{ $criterioSeleccionado->nombre }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" wire:click='asignarCriterios({{$criterioSeleccionado->id}})' data-bs-dismiss="modal">Continuar</button>
            </div>
        </div>
    </div>
</div>