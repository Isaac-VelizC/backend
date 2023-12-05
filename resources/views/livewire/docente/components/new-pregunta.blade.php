<div>
    <div class="iq-navbar-header" style="height: 80px;"></div> 
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        @if(session('success'))
            <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <form wire:submit.prevent="guardarPregunta">
                @csrf
                <div class="text-center">
                    <button type="submit" class="btn btn-secondary btn-sm">Guardar</button>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="window.history.back()">x</button>
                </div><hr>
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Pregunta</label>
                                    <textarea class="form-control" wire:model="pregunta.pregunta" rows="2" required></textarea>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model='pregunta.con_nota'>
                                            <label class="form-check-label" >Sin Nota</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="text" id="preguntaNotaInput" class="form-control" wire:model='pregunta.nota'>
                                            @error('pregunta.nota') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Fecha Limite (Opcional)</label>
                                        <input  type="date" class="form-control" wire:model="pregunta.limite" max="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label class="form-label">Tema:</label>
                                        <select class="selectpicker form-control" wire:model="pregunta.tema">
                                            <option value="" selected>Sin Tema</option>
                                                @foreach ($temasCurso as $item)
                                                    <option value="{{$item->id}}">{{ $item->tema }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@script
<script>
    $wire.on('redirectBack', function () {
        history.back();
    });
</script>
@endscript
</div>