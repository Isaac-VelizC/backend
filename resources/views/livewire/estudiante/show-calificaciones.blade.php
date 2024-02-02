<div>
    <div class="col-sm-12">
      @if(session('success'))
         <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
      @endif
      @if(session('error'))
         <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
      @endif
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive pricing pt-2">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th colspan="5" class="bg-light">Materia</th>
                            </tr>
                            @if (count($notas) > 0)
                                @foreach ($notas as $item)
                                    <tr>
                                        <th scope="row">{{ $item['materia'] }}</th>
                                        <td class="text-center">{{ $item['calificacion'] }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <th class="text-black">No hay materias</th>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
     </div>
</div>
