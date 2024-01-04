<div>
    <div class="iq-navbar-header" style="height: 80px;"></div> 
    
    <div class="conatiner-fluid content-inner mt-n5 py-0">
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
       <div class="row">
          <div class="col-md-12">
             <div class="row-cols-1">
                <div class="col-sm-12">
                   <div class="card">
                      <div class="row no-gutters">
                         <div class="col-md-8">
                            <div class="card-body text-black">
                               <h4>{{ $tarea->titulo }}</h4>
                               <p class="mt-2">{!! $tarea->descripcion !!}</p>
                            <div class="mb-5 pt-2">
                              <p class="line-around text-gray mb-0"><span class="line-around-1">Información</span></p>
                            </div>
                                <p><b>Tipo de trabajo: </b>{{$tarea->tipo}}</p>
                                @if ($tarea->tema_id)
                                    <p><b>Tema: </b>{{ $tarea->tema->tema }}</p>
                                @endif
                                <p><b>Fecha:</b> Se resive trabajos hasta {{ $tarea->fin }}</p>
                                @if ($ingredientesTarea)
                                    <hr>
                                    <p><b>Ingredientes</b></p>
                                    @foreach ($ingredientesTarea as $ingrediente)
                                        <p class="h6 mx-2">
                                            <span class="badge bg-warning">{{ $ingrediente }}</span>
                                        </p>
                                    @endforeach
                                @endif
                                @if ( $tarea->receta )
                                    <hr>
                                    <p><b>Receta</b></p>
                                    <p><a href="{{ route('admin.show.receta', $tarea->receta->id ) }}">{{ $tarea->receta->titulo }}</a></p>
                                @endif
                            </div>
                         </div>
                         <div class="col-md-4">
                            <div class="card-body text-center h-100 iq-single-card">
                                <div class="flex-wrap mb-4 d-flex align-itmes-center justify-content-between">
                                    @if (auth()->user()->hasRole('Docente'))
                                        <div class="align-itmes-center">
                                            <div class="ms-3">
                                                <h3>{{ $entregas }}</h3>
                                                <small class="mb-0">Respuestas</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-itmes-center">
                                            <div class="ms-3">
                                                <h3>{{ $calificadas }}</h3>
                                                <small class="mb-0">Calificadas</small>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if ($filesTarea)
                                    @foreach ($filesTarea as $file)
                                        <ol class="list-group">
                                            <a href="{{ asset($file->url) }}" target="_blank">
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                                        <path d="M22 24h-18v-22h12l6 6v16zm-7-21h-10v20h16v-14h-6v-6zm-1-2h-11v21h-1v-22h12v1zm2 7h4.586l-4.586-4.586v4.586z"/>
                                                    </svg>
                                                    <div class="me-auto">
                                                        <div class="fw-bold">{{ $file->nombre }}</div>
                                                        {{ $file->fecha }}
                                                    </div>
                                                </li>
                                            </a>
                                        </ol>
                                    @endforeach
                                @endif
                            </div>
                         </div>
                      </div>
                   </div>
                   @if (auth()->user()->hasRole('Docente'))
                        @include('docente.cursos.widgets.calificar_trabajo')
                   @elseif(auth()->user()->hasRole('Estudiante'))
                    <div class="card">
                        <div class="card-header pb-3">
                            <h3 class="block-title">Realizar Entrega</h3>
                        </div>
                        <div class="card-body">
                                <div class="table-responsive pricing pt-2">
                                    <table id="my-table" class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Estado de Entrega</th>
                                            <td class="text-center child-cell">
                                                @if ($trabajoSubido)
                                                    {{ $trabajoSubido->estado }}
                                                @else
                                                    Pendiente
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Entrega</th>
                                            <td class="child-cell">
                                                @if ($filesSubidos)
                                                    @foreach ($filesSubidos as $file)
                                                        <p><a href="{{ asset($file->url) }}"><i class="bi bi-files"></i> {{$file->nombre}}</a></p>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Nota</th>
                                            <td class="text-center child-cell">
                                                @if ($trabajoSubido)
                                                    {{ $trabajoSubido->nota }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Modificado</th>
                                            <td class="text-center child-cell">
                                                @if ($trabajoSubido)
                                                    {{ $trabajoSubido->updated_at }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Fecha Limite</th>
                                            <td class="text-center child-cell">
                                                {{ $tarea->fin }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                                <hr>
                            <div class="row">
                                @if ($tarea->fin > $fechaActual)
                                    <div class="text-center">
                                        @if ($trabajoSubido && ($trabajoSubido['estado'] ?? '') != 'Calificado')
                                            <button type="button" class="btn btn-outline-primary btn-sm" wire:click='editarTareasSubido({{$trabajoSubido['id']}})'>Editar</button>
                                            <button type="button" class="btn btn-outline-danger btn-sm" wire:click='borrarTareaSubido({{$trabajoSubido['id']}})'>Borrar</button>
                                        @endif
                                        @if (!$trabajoSubido && ($trabajoSubido['estado'] ?? '') != 'Calificado')
                                            <a type="button" class="btn btn-secondary btn-sm" href="{{ route('estudiante.subir.tarea', ['id' => $tarea->id, 'edit' => 0]) }}">Subir</a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                   @endif
                </div>
             </div>
          </div>
       </div>
    </div>
</div>    