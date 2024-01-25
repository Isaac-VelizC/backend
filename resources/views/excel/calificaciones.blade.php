<table>
    <thead>
    <tr>
      <th>N°</th>
      <th>Estudiante</th>
      <th>Nota</th>
    </tr>
    </thead>
    <tbody>
      @foreach ($notas as $item)
          <tr>
              <td>{{ $i++ }}</td>
              <td>{{ $item->estudiante->persona->nombre }} {{ $item->estudiante->persona->ap_paterno }} {{ $item->estudiante->persona->ap_materno }}</td>
              <td>{{ $item->calificacion }}</td>
          </tr>
      @endforeach
    </tbody>
  </table>