@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 170px;">
   <div class="container-fluid iq-container text-black">
       <div class="row">
           <div class="col-md-12">
               <h5>{{ Breadcrumbs::render('Materias.show', $curso) }}</h5>
           </div>
       </div>
   </div>
</div>

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
                     <div class="col-md-8">
                        <div class="card-body">
                           <h4>{{ $curso->curso->nombre }}</h4>
                           <p class="mt-2">{{ $curso->curso->descripcion }}</p>
                           <div class="mb-5 pt-2">
                              <p class="line-around text-gray mb-0"><span class="line-around-1">Información</span></p>
                           </div>
                           <div class="row">
                              <p><b>Docente:</b> {{ $curso->docente->persona->nombre }} {{ $curso->docente->persona->ap_paterno }} {{ $curso->docente->persona->ap_materno }}</p>
                              <p><b>Horario:</b> {{ $curso->horario->turno }} {{ $curso->horario->inicio }} - {{ $curso->horario->fin }}</p>
                              <p><b>Aula:</b> {{ $curso->aula->nombre }} - <b>Codigo:</b> {{ $curso->aula->codigo }}</p>
                              <p><b>Fecha:</b> de {{ $curso->fecha_ini }} al {{ $curso->fecha_fin }}</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="card-body text-center h-100 iq-single-card">
                              <div class="bd-example">
                                 <svg class="bd-placeholder-img img-thumbnail" width="400" height="400" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="A generic square placeholder image with a white border around it, making it resemble a photograph taken with an old instant camera: Imagen" preserveAspectRatio="xMidYMid slice" focusable="false">
                                    <rect width="100%" height="100%" fill="#868e96"></rect>
                                 </svg>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="card">
                  <div class="card-header d-flex align-items-center justify-content-between flex-wrap pb-3">
                     <h3 class="block-title">Listado de Estudiantes</h3>
                     <p>Cupos: {{ count($estudiantes) }} / {{$curso->cupo}}</p>
                  </div>
                  <div class="card-body p-0">
                     <div class="table-responsive pricing pt-2">
                        <table id="my-table" class="table mb-0">
                           <tbody>
                              @if (count($estudiantes) > 0)
                                 @foreach ($estudiantes as $estud)
                                 <?php
                                    $nota = App\Models\Calificacion::where('estudiante_id', $estud->id)->where('curso_id', $curso->id)->first();
                                 ?>
                                    <tr>
                                       <th>{{$num++}}</th>
                                       <th scope="row">{{ "{$estud->persona->nombre} {$estud->persona->ap_paterno} {$estud->persona->ap_materno}" }}</th>
                                       <td class="text-center child-cell">
                                          {{ $nota->calificacion ?? 'Pendiente' }}
                                       </td>
                                    </tr>
                                 @endforeach
                              @else
                                 <div class="text-center">
                                    <p>No hay estudiantes inscritos</p>
                                 </div>
                              @endif
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection