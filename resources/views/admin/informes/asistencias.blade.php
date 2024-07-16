@extends('layouts.app')

@section('content')
    
    <div class="iq-navbar-header" style="height: 80px;"></div>
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-md-12">
                <div class="row row-cols-1">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="row no-gutters">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="text-center">
                                            <h4 class="card-title mb-0">REPORTES DE ASISTENCIAS</h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <form class="needs-validation" novalidate id="searchAsistencias">
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <select name="materia" class="form-select" required>
                                                    <option value="" selected disabled>Seleccionar una materia</option>
                                                    @foreach ($materias as $materia)
                                                        <option value="{{ $materia->id }}">{{ $materia->curso->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select name="meses" class="form-select">
                                                    <option value="" selected>Mes</option>
                                                    @foreach ($months as $key => $item)
                                                        <option value="{{ $key }}">{{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select name='year' class="form-select" required>
                                                    <option value="" selected disabled>Año</option>
                                                    @for ($year = date('Y'); $year >= $startYear; $year--)
                                                        <option value="{{ $year }}" {{ $currentYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="text-center">
                                                <button type="reset" class="btn btn-primary btn-sm">Cancelar</button>
                                                <button type="submit" class="btn btn-secondary btn-sm">Buscar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="flex-wrap d-flex justify-content-between align-items-center">
                                    <h3><b>Resultados</b></h3>
                                </div>
                                <br>
                                <div class="table-responsive">
                                  <div id="resultados"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<script>
    document.getElementById('searchAsistencias').addEventListener('submit', function (event) {
        event.preventDefault();

        let formData = new FormData(this);

        axios.post('/asistencias/export', formData)
        .then(function (response) {
                var resultados = response.data.data;

                // Verificar si la lista de resultados está vacía
                if (resultados.length === 0) {
                    // Si la lista está vacía, mostrar un mensaje
                    document.getElementById("resultados").innerHTML = '<h6 class="text-center">No se encontraron resultados.</h6>';
                    return;
                }
                // Construir la presentación de los resultados en la tabla
                var htmlResultados = '<table id="datatable" class="table table-striped" data-toggle="data-table">';
                htmlResultados += '<thead>';
                htmlResultados += '<tr>';
                // Obtener los nombres de los campos del primer resultado
                var campos = Object.keys(resultados[0]);

                // Iterar sobre los nombres de los campos y construir las columnas de la tabla
                campos.forEach(function (campo) {
                    htmlResultados += '<th>' + campo + '</th>';
                });

                htmlResultados += '</tr>';
                htmlResultados += '</thead>';
                htmlResultados += '<tbody>';

                // Iterar sobre los resultados y construir las filas de la tabla
                resultados.forEach(function (resultado) {
                    htmlResultados += '<tr>';
                    campos.forEach(function (campo) {
                        htmlResultados += '<td class="text-center">' + resultado[campo] + '</td>';
                    });
                    htmlResultados += '</tr>';
                });

                htmlResultados += '</tbody>';
                htmlResultados += '</table>';
                // Actualizar el contenido del contenedor de resultados
                document.getElementById("resultados").innerHTML = htmlResultados;
            })
            .catch(function (error) {
                // Obtener el mensaje de error del objeto de error
                var errorMessage = error.response.data.error;
                // Construir el mensaje de error
                var htmlError = '<div class="alert alert-danger alert-dismissible show fade">';
                htmlError += '<span>' + errorMessage + '</span>';
                htmlError += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                htmlError += '</div>';
                // Mostrar el mensaje de error en el contenedor
                document.getElementById("error").innerHTML = htmlError;
            });
    });
</script>

@endsection