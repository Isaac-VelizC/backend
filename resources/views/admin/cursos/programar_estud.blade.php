@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 150px;">
  <div class="iq-container">
      <div class="row">
        <div class="col-md-12">
            <h5>{{ Breadcrumbs::render( 'Materias.programar') }}</h5>
        </div>
      </div>
  </div>
</div> 

<div class="conatiner-fluid content-inner mt-n5 py-0">
   <div id="alerts"></div>
  <div class="row">
     <div class="col-sm-12">
        <div class="card">
           <div class="card-body">
               <div class="flex-wrap">
                    <h4 class="text-xl font-weight-bold">Materia: {{ $materia->curso->nombre }}</h4>
                    <h5>cupos: {{ $materia->cupo }}</h5>
               </div>
              <br>
              <div class="table-responsive">
                <div class="text-center">
                    <button id="seleccionarTodo" class="btn btn-outline-success"><i class="bi bi-check-all"></i></button>
                    <button id="deseleccionarTodo" class="btn btn-outline-danger"><i class="bi bi-x-circle"></i></button>
                    <button id="enviarDatos" class="btn btn-outline-primary"><i class="bi bi-send"></i></button>
                    <input type="hidden" name="id_materia" value="{{ $materia->id }}">
                </div>
                <table id="datatableMaterias" class="table table-striped" data-toggle="data-table">
                    <thead>
                       <tr>
                          <th>Seleccionar</th>
                          <th>Nombre</th>
                          <th>Cedula</th>
                          <th>Turno</th>
                          <th>Estado</th>
                       </tr>
                    </thead>
                    <tbody>
                        @foreach ($estudiantes as $item)
                            <tr>
                                <td class="text-center">
                                    <input class="form-check-input seleccionar" type="checkbox" name="estudiante[]" value="{{ $item->id }}">
                                </td>
                                <td><a href="{{ route('admin.E.show', $item->persona->id) }}">{{ $item->persona->nombre }} {{ $item->persona->ap_paterno }} {{ $item->persona->ap_materno }}</a></td>
                                <td class="text-center"><p>{{ $item->persona->ci }}</p></td>
                                <td class="text-center">{{ $item->turnos->turno }}</p></td>
                                <td class="text-center">
                                    <span class="badge rounded-pill @if ($item->estado == true) bg-info text-white">
                                        Activo @else bg-danger text-white">Inactivo @endif 
                                    </span>
                                </td>
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

<script>
    // Manejar la selección de todos los checkboxes
    document.getElementById('seleccionarTodo').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('.seleccionar');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = true;
        });
    });

    // Manejar la deselección de todos los checkboxes
    document.getElementById('deseleccionarTodo').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('.seleccionar');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
    });
    document.getElementById('enviarDatos').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('.seleccionar:checked');
        var datosSeleccionados = [];
        checkboxes.forEach(function(checkbox) {
            datosSeleccionados.push(checkbox.value);
        });
        var idMateria = document.querySelector('input[name="id_materia"]').value;
        // Enviar datos utilizando Axios
        axios.post('/save/materia/estudiantes', {
            estudiantes: datosSeleccionados,
            id_materia: idMateria
        })
        .then(function (response) {
            if (response.data.success) {
            document.getElementById('alerts').innerHTML = '<div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert"><span>' + response.data.message + '</span><button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            } else {
                document.getElementById('alerts').innerHTML = '<div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert"><span>' + response.data.message + '</span><button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
        })
        .catch(function (error) {
            // Manejar errores
            console.error(error);
        });
    });

</script>


@endsection