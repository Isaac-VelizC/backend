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
                                    <th></th>
                                    @foreach ($trabajos as $tra)
                                        <th class="text-center">{{ $tra->titulo }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estudiantes as $est)
                                    <tr class="">
                                        <td class="">{{ $est->persona->nombre }} {{ $est->persona->ap_paterno }} {{ $est->persona->ap_materno }}</td>
                                        <td>tarea1</td>
                                        <td>tarea2</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
