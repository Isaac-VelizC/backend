@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 80px;"></div>

<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
       <div class="col-md-12 col-lg-12">
          <div class="row row-cols-1">
             <div class="overflow-hidden d-slider1 ">
                <ul  class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                  @foreach ($cursos_A as $item)
                     <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1000">
                        <div class="card-body">
                        <a href="{{ route('cursos.curso', [$item->id]) }}">
                           <div class="progress-widget">
                              <div class="rounded p-3 bg-soft" style="background-color: {{ $item->curso->color }}">
                                 <i class="fa fa-users"></i>
                              </div>
                              <div class="progress-detail">
                                 <p  class="mb-2">{{ $item->curso->nombre }}</p>
                                 <h4>{{ $item->horario->turno }}</h4>
                              </div>
                           </div>
                        </a>
                        </div>
                     </li>
                  @endforeach
                </ul>
                <div class="swiper-button swiper-button-next"></div>
                <div class="swiper-button swiper-button-prev"></div>
             </div>
          </div>
       </div> 
      </div>
      <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                               <h4 class="card-title">Listado de cursos anteriores</h4>
                            </div>
                         </div>
                         <div class="card-body">
                            <div class="table-responsive">
                               <table id="datatable" class="table table-striped" data-toggle="data-table">
                                  <thead>
                                     <tr>
                                        <th>Nombre</th>
                                        <th>Aula</th>
                                        <th>Horario</th>
                                        <th>Modalidad</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th></th>
                                     </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($cursos_I as $item)
                                    <tr>
                                       <td><p>{{ $item->curso->nombre }}</p></td>
                                       <td>
                                         <p>{{ $item->aula->codigo }}</p>
                                       </td>
                                       <td>
                                         <p>{{ $item->horario->turno }}</p>
                                       </td>
                                       <td>
                                         <p>{{ $item->curso->semestre->nombre }}</p>
                                       </td>
                                       <td>
                                         <p>{{ $item->fecha_ini }}</p>
                                       </td>
                                       <td>
                                         <p>{{ $item->fecha_fin }}</p>
                                       </td>
                                       <td>
                                         <div class="flex align-items-center list-user-action">
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Ver"  href="#">
                                               <i class="bi bi-eye"></i>
                                            </a>
                                         </div>
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
    </div>
</div>
@endsection