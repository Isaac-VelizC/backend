<style>
   .input-personalizado {
       border: none;
       outline: none;
       background-color: rgb(247, 247, 247);
       padding: 8px;
       width: 25%;
   }
</style>
<div class="card">
   <div class="row">
      <div class="col-sm-8">
         <div class="card-header pb-3">
            <h3 class="block-title">Listado de Estudiantes</h3>
         </div>
         <div class="card-body p-0">
            @error("errorNota")
               <span class="text-danger">{{ $message }}</span>
            @enderror
            <div class="table-responsive pricing pt-2">
               <table id="my-table" class="table mb-0">
                  <tbody>
                     @if (count($estudiantesConTareas) > 0)
                        @foreach ($estudiantesConTareas as $item)
                           <tr>
                              <th>{{ $num++ }}</th>
                              <th scope="row">
                                 <a href="#" wire:click='VerTarea({{$item['estudiante']->id}})'>
                                    {{ $item['estudiante']->persona->nombre }} {{ $item['estudiante']->persona->ap_paterno }} {{ $item['estudiante']->persona->ap_materno }}
                                 </a>
                              </th>
                              <td class="text-center child-cell">
                                 @if ($item['haEnviadoTarea'])
                                     @if(isset($trabajoSubido[$item['estudiante']->id]))
                                         <input type="text" wire:model.lazy="trabajoSubido.{{ $item['estudiante']->id }}" placeholder="0" class="input-personalizado" wire:change="calificarTarea({{ $item['estudiante']->id }})">
                                     @else
                                         No disponible
                                     @endif
                                 @else
                                     No Enviada
                                 @endif
                             </td>
                           </tr>
                        @endforeach
                     @else
                        <div class="text-center">
                           <p>No hay estudiantes</p>
                        </div>
                     @endif
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <div class="col-sm-4">
         <div class="card-header pb-3">
            <h3 class="block-title">Tareas Subidas</h3>
         </div>
         <div class="card-body p-0">
            <div class="table-responsive pricing pt-2">
               <p>{{ $tareaDelEstudiante }}</p>
               @if ($trabajosSubidosCali)
                  @foreach ($trabajosSubidosCali as $file)             
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
               @else
                  <div class="text-center">
                     <p>No envio la tarea</p>
                  </div>
               @endif
            </div>
         </div>
      </div>
   </div>
 </div>