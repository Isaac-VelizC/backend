<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ 'Calificaciones' }}</title>
</head>
<body>
    <div class="invoice p-3 mb-3">
        <div class="row">
          <div class="col-12">
            <p><h3>{{ $titulo }}</h3>
              <small class="float-right">Fecha: {{ $fecha }}</small>
            </p>
          </div>
        </div>
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            De:
            <strong>{{ $curso->docente->persona->nombre }} {{ $curso->docente->persona->ap_paterno }} {{ $curso->docente->persona->ap_materno }}</strong>
            <address>
                <hr>
                Materia: {{ $curso->curso->nombre }}<br>
                Turno: {{ $curso->horario->turno }}
            </address>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <table class="table">
              <thead>
              <tr>
                <th>N°</th>
                <th>Estudiante</th>
                <th>Asistencia</th>
                <th>fecha</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($asistencias as $item)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item->estudiante->persona->nombre }} {{ $item->estudiante->persona->ap_paterno }} {{ $item->estudiante->persona->ap_materno }}</td>
                        <td>{{ $item->asistencia == 'P' ? 'presente' : ($item->asistencia == 'F' ? 'falta' : 'Licencia') }}</td>
                        <td>{{ $item->fecha }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
</body>
</html>