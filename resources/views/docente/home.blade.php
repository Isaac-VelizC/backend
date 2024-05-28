@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 90px;">
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
   <div class="row">
      <div class="col-md-12 col-lg-12">
         <div class="row row-cols-1">
            <div class="overflow-hidden d-slider1 ">
               <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                  <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1000">
                     <a href="{{ route('chef.cursos') }}">
                        <div class="card-body">
                           <div class="progress-widget">
                              <div class="rounded p-3 bg-soft-warning">
                                 <i class="fa fa-users"></i>
                              </div>
                              <div class="progress-detail">
                                 <p class="mb-2">Cursos</p>
                                 <h4 class="counter">{{ count($cursos) }}</h4>
                              </div>
                           </div>
                        </div>
                     </a>
                  </li>
                  <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1100">
                     <a href="{{ route('admin.ingredientes') }}">
                        <div class="card-body">
                           <div class="progress-widget">
                              <div class="rounded p-3 bg-soft-dark">
                                 <i class="fa fa-users"></i>
                              </div>
                              <div class="progress-detail">
                                 <p class="mb-2">Recetas</p>
                                 <h4 class="counter">{{ count($recetas) }}</h4>
                              </div>
                           </div>
                        </div>
                     </a>
                  </li>
               </ul>
               <div class="swiper-button swiper-button-next"></div>
               <div class="swiper-button swiper-button-prev"></div>
            </div>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-lg-6">
         @if (count($materiasA) > 0 )
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">Materias</h4>
                  </div>
               </div>
         @endif
         <br>
         <div class="row">
            @foreach ($materiasA as $item)
               <div class="col-md-6 text-center">
                  <div class="card rounded-3 " style="background: {{ $item->curso->color }}">
                     <div class="card-body">
                        <h4 class="my-0 fw-normal">{{ $item->curso->nombre }}</h4>
                        <br>
                        <a type="button" href="{{ route('cursos.curso', $item->id) }}" class="btn btn-outline-primary">Entrar</a>
                     </div>
                  </div>
               </div>
            @endforeach
         </div>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h4 class="card-title">Recetas Recientes</h4>
               </div>
            </div>
            <div class="card-body p-0">
               <div class="table-responsive mt-4">
                  <table id="basic-table" class="table table-striped mb-0" role="grid">
                     <thead>
                        <tr>
                           <th>Nombre</th>
                           <th>Tipo</th>
                           <th>Porción</th>
                           <th>Tiempo</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($misRecetas as $item)
                            <tr>
                              <td>{{ $item->titulo }}</td>
                              <td>{{ $item->titulo }}</td>
                              <td>{{ $item->porcion }}</td>
                              <td>{{ $item->tiempo }}</td>
                            </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-6">
         <div class="card">
            <div class="card-body">
               <div id="calendar1" class="calendar-s"></div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection