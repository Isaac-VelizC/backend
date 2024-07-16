@extends('layouts.app')
@section('content')
   <div class="position-relative iq-banner">
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
                                           <h5 class="card-title mb-0">REPORTES DE ESTUDIANTES</h5>
                                       </div>
                                   </div>
                                   <hr>
                                   <form class="needs-validation" novalidate id="searchForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name='horario' class="form-select">
                                                <option value="" selected>Seleccionar Horario</option>
                                                @foreach ($horarios as $hora)
                                                    <option value="{{ $hora->id }}">{{ $hora->turno }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select name='semestre' class="form-select">
                                                <option value="" selected>Seleccionar Semestre</option>
                                                @foreach ($semestres as $semestre)
                                                    <option value="{{ $semestre->id }}">{{ $semestre->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select name='estado' class="form-select">
                                                <option value="" selected>Estado</option>
                                                <option value="0">Activo</option>
                                                <option value="1">Inactivo</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select name='graduado' class="form-select">
                                                <option value="" selected>Graduados</option>
                                                <option value="Si">Si</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <!--div class="col-md-2">
                                            <select name='promedio' class="form-select">
                                                <option value="" selected>Promedios</option>
                                                <option value="51">51</option>
                                                <option value="60">60</option>
                                                <option value="70">70</option>
                                                <option value="80">80</option>
                                                <option value="90">90</option>
                                            </select>
                                        </!--div-->
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
    document.getElementById('searchForm').addEventListener('submit', function (event) {
        event.preventDefault();

        let formData = new FormData(this);

        axios.post('/estudiantes/export', formData)
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