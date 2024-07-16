<style>
   .input-personalizado {
       border: none;
       outline: none;
       background-color: rgb(255, 255, 255);
       padding: 8px;
       width: auto;
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
                              <th scope="row" style="cursor: pointer;">
                                 <p wire:click='VerTarea({{$item['estudiante']->id}})'>
                                    {{ $item['estudiante']->persona->nombre }} {{ $item['estudiante']->persona->ap_paterno }} {{ $item['estudiante']->persona->ap_materno }}
                                 </p>
                              </th>
                              <td class="text-center">
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
         <div class="card-body p-2">
            <div class="table-responsive pricing pt-2">
               <p class="text-black">{{ $tareaDelEstudiante }}</p>
               @if ($trabajosSubidosCali)
                  @foreach ($trabajosSubidosCali as $file)             
                     <ol class="list-group">
                        <a href="{{ asset($file->url) }}" target="_blank">
                           <li class="list-group-item d-flex justify-content-between align-items-start gap-2">
                              <i class="bi bi-file-text"></i>
                              <div class="me-auto">
                                 <div class="fw-bold">{{ $file->nombre }}</div>
                                 {{ $file->fecha }}
                              </div>
                           </li>
                        </a>
                     </ol>
                  @endforeach
                  <p class="pt-3">{{ $textTarea ?? '' }}</p>
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