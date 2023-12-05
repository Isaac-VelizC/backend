<div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="header-title">
                    <h4 class="card-title mb-0">Calificaciones</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">ESTUDIANTE</th>
                                    <th class="text-center">PPRESENTE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estudiantes as $est)
                                    <tr class="">
                                        <td class="">{{ $est->persona->nombre }} {{ $est->persona->ap_paterno }} {{ $est->persona->ap_materno }}</td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            <a wire:click='guardarAsistencia()' type="button" class="btn btn-primary">Guardar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
