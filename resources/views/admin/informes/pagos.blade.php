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
                                            <h4 class="card-title mb-0">REPORTES DE PAGOS</h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <form class="needs-validation" novalidate id="searchFormPagos">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <select id="estudiante" class="form-select" name="selectEstudiante"></select>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-select" name="selectedMonth">
                                                    <option value="">Seleccionar Mes</option>
                                                    @foreach ($months as $key => $month)
                                                        <option value="{{ $key }}">{{ $month }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <select name='year' class="form-select" required>
                                                    <option value="" selected>Seleccionar Año</option>
                                                    @for ($year = date('Y'); $year >= 2020; $year--)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="text-center">
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" class="form-check-input" name="estado">
                                                    <label class="form-check-label pl-2">Monto Total por Estudiante</label>
                                                </div>
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
    @section('scripts')
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $("#estudiante").select2({
                placeholder: 'Escriba el nombre o nit/ci',
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
                                    text: item.persona.nombre + ' ' + item.persona.ap_paterno + ' ' + item.persona.ap_materno + ' -- ' + item.persona.ci
                                }
                            })
                        };
                    },
                },
            });
        });
    </script>
    @endsection
    <script>
        document.getElementById('searchFormPagos').addEventListener('submit', function (event) {
            event.preventDefault();
    
            let formData = new FormData(this);
    
            axios.post('/pagos/export', formData)
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
                            htmlResultados += '<td>' + resultado[campo] + '</td>';
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