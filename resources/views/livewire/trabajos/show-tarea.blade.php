<div>
    <div class="iq-navbar-header" style="height: 80px;"></div> 
    
    <div class="conatiner-fluid content-inner mt-n5 py-0">
       @if(session('success'))
           <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
               <span>{{ session('success') }}</span>
               <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
           </div>
       @endif
       <div class="row">
          <div class="col-md-12">
             <div class="row row-cols-1">
                <div class="col-sm-12">
                   <div class="card">
                      <div class="row no-gutters">
                         <div class="col-md-7">
                            <div class="card-body">
                               <h4>{{ $tarea->titulo }}</h4>
                               <p class="mt-2">{{ $tarea->descripcion }}</p>
                               <div class="mb-5 pt-2">
                                  <p class="line-around text-gray mb-0"><span class="line-around-1">Información</span></p>
                               </div>
                               <div class="row">
                                    <p><b>Tipo de trabajo: </b>{{$tarea->tipo->nombre}}</p>
                                    @if ($tarea->tema_id)
                                        <p><b>Tema: </b>{{ $tarea->tema->tema }}</p>
                                    @endif
                                    <p><b>Fecha:</b> Se resive respuestas hasta {{ $tarea->fin }}</p>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-5">
                            <div class="card-body text-center h-100 iq-single-card">
                                <div class="flex-wrap mb-4 d-flex align-itmes-center justify-content-between">
                                    @if (auth()->user()->hasRole('Docente'))
                                        <div class="d-flex align-itmes-center me-0 me-md-4">
                                            <div>
                                                <div class="p-3 mb-2 rounded bg-soft-primary">
                                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.9303 7C16.9621 6.92913 16.977 6.85189 16.9739 6.77432H17C16.8882 4.10591 14.6849 2 12.0049 2C9.325 2 7.12172 4.10591 7.00989 6.77432C6.9967 6.84898 6.9967 6.92535 7.00989 7H6.93171C5.65022 7 4.28034 7.84597 3.88264 10.1201L3.1049 16.3147C2.46858 20.8629 4.81062 22 7.86853 22H16.1585C19.2075 22 21.4789 20.3535 20.9133 16.3147L20.1444 10.1201C19.676 7.90964 18.3503 7 17.0865 7H16.9303ZM15.4932 7C15.4654 6.92794 15.4506 6.85153 15.4497 6.77432C15.4497 4.85682 13.8899 3.30238 11.9657 3.30238C10.0416 3.30238 8.48184 4.85682 8.48184 6.77432C8.49502 6.84898 8.49502 6.92535 8.48184 7H15.4932ZM9.097 12.1486C8.60889 12.1486 8.21321 11.7413 8.21321 11.2389C8.21321 10.7366 8.60889 10.3293 9.097 10.3293C9.5851 10.3293 9.98079 10.7366 9.98079 11.2389C9.98079 11.7413 9.5851 12.1486 9.097 12.1486ZM14.002 11.2389C14.002 11.7413 14.3977 12.1486 14.8858 12.1486C15.3739 12.1486 15.7696 11.7413 15.7696 11.2389C15.7696 10.7366 15.3739 10.3293 14.8858 10.3293C14.3977 10.3293 14.002 10.7366 14.002 11.2389Z" fill="currentColor"></path>                                            
                                                </svg>
                                                </div>
                                            </div>
                                            <div class="ms-3">
                                                <h3>{{ count($entregas) }}</h3>
                                                <small class="mb-0">Respuestas</small>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="d-flex align-itmes-center">
                                        <div>
                                            <div class="p-3 mb-2 rounded bg-soft-info">
                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.1213 11.2331H16.8891C17.3088 11.2331 17.6386 10.8861 17.6386 10.4677C17.6386 10.0391 17.3088 9.70236 16.8891 9.70236H14.1213C13.7016 9.70236 13.3719 10.0391 13.3719 10.4677C13.3719 10.8861 13.7016 11.2331 14.1213 11.2331ZM20.1766 5.92749C20.7861 5.92749 21.1858 6.1418 21.5855 6.61123C21.9852 7.08067 22.0551 7.7542 21.9652 8.36549L21.0159 15.06C20.8361 16.3469 19.7569 17.2949 18.4879 17.2949H7.58639C6.25742 17.2949 5.15828 16.255 5.04837 14.908L4.12908 3.7834L2.62026 3.51807C2.22057 3.44664 1.94079 3.04864 2.01073 2.64043C2.08068 2.22305 2.47038 1.94649 2.88006 2.00874L5.2632 2.3751C5.60293 2.43735 5.85274 2.72207 5.88272 3.06905L6.07257 5.35499C6.10254 5.68257 6.36234 5.92749 6.68209 5.92749H20.1766ZM7.42631 18.9079C6.58697 18.9079 5.9075 19.6018 5.9075 20.459C5.9075 21.3061 6.58697 22 7.42631 22C8.25567 22 8.93514 21.3061 8.93514 20.459C8.93514 19.6018 8.25567 18.9079 7.42631 18.9079ZM18.6676 18.9079C17.8282 18.9079 17.1487 19.6018 17.1487 20.459C17.1487 21.3061 17.8282 22 18.6676 22C19.4969 22 20.1764 21.3061 20.1764 20.459C20.1764 19.6018 19.4969 18.9079 18.6676 18.9079Z" fill="currentColor"></path>                                            
                                            </svg>                                        
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h3>81K</h3>
                                            <small class="mb-0">Calificadas</small>
                                        </div>
                                    </div>
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
                                        @if ($trabajoSubido)
                                            <button type="button" class="btn btn-outline-primary btn-sm" wire:click='editarTareasSubido({{$trabajoSubido->id}})'>Editar</button>
                                            <button type="button" class="btn btn-outline-danger btn-sm" wire:click='borrarTareaSubido({{$trabajoSubido->id}})'>Borra</button>
                                        @else
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