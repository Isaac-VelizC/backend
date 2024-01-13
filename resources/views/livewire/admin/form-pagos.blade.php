<div>
    <div class="iq-navbar-header" style="height: 90px;"></div>
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">                
            <div class="col-sm-12 col-lg-12">
                @if(session('error'))
                    <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
                        <span>{{ session('error') }}</span>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="new-user-info">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                <h4 class="card-title">Formulario de pago</h4>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12 col-lg-12">
                                    <form class="needs-validation" novalidate wire:submit.prevent='guardarPago'>
                                        @csrf
                                            <div class="col-sm-12 col-lg-12">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="form-label"> <span class="text-danger">*</span> Forma de Pago:</label>
                                                        <select class="form-select mb-3 shadow-none" wire:model='datosPagos.formaPago' required>
                                                            @foreach ($formaPagos as $met)
                                                                <option value="{{ $met->id }}">{{ $met->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('metodo')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label class="form-label"><span class="text-danger">*</span> Estudiante:</label>
                                                        <select id="estudiante" class="form-select" wire:model="datosPagos.estudiante" required></select>
                                                        @error('estudiante')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-lg-3">
                                                        <label class="form-label"><span class="text-danger">*</span> Fecha:</label>
                                                        <input type="date" class="form-control" wire:model='datosPagos.fecha' required>
                                                        @error('fecha')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-lg-3">
                                                        <label class="form-label"><span class="text-danger">*</span> Monto:</label>
                                                        <input type="number" step="0.01" class="form-control" wire:model="datosPagos.monto" value="{{ old('monto') }}" placeholder="Bs." required>
                                                        @error('monto')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>                            
                                                    <div class="form-group col-lg-12">
                                                        <label class="form-label">Descripción: (Opcional) </label>
                                                        <textarea type="text" class="form-control" wire:model="datosPagos.descripcion" placeholder="Escribe una breve descripción"></textarea>
                                                        @error('descripcion')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancelar</button>
                                            <div class="btn-group">
                                                <button class="btn btn-danger" type="submit">Guardar</button>
                                                <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="visually-hidden">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="">Guardar e Imprimir</a></li>
                                                </ul>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('scripts')
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $("#estudiante").select2({
                placeholder: 'Escriba el nombre',
                allowClear: true,
                ajax: {
                    url: "{{ route('search.estudiantes') }}",
                    type: "post",
                    delay: 250,
                    dataType: 'json',
                    data: function(params) {
                        return {
                            name: params.term,
                            "_token": "{{ csrf_token() }}",
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.persona.nombre + ' ' + item.persona.ap_paterno + ' ' + item.persona.ap_materno
                                }
                            })
                        };
                    },
                },
            });
        });
    </script>
 @endsection
</div>
