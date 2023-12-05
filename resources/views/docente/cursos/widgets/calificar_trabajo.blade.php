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
                                       Enviada
                                    @else
                                       No Enviada
                                    @endif
                              </td>
                              <td class="text-center child-cell">
                                 <input type="text" wire:model.lazy="nota" placeholder="0" class="input-personalizado" wire:change="calificarTarea({{$item['estudiante']->id}})">
                                 @if($guardando)
                                    <span class="text-muted">Guardando...</span>
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
               @if ($trabajosSubidosCali)
                   @foreach ($trabajosSubidosCali as $item)
                       <p><a href="#">{{$item->nombre}}</a></p>
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