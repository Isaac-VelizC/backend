@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 90px;">
</div> 
<div class="conatiner-fluid content-inner mt-n5 py-0">
   <div class="row">
      <div class="col-md-12 col-lg-12">
         <div class="row row-cols-1">
            <div class="overflow-hidden d-slider1 ">
               <ul  class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                  <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1000">
                     <a href="{{ route('chef.cursos') }}">   
                        <div class="card-body">
                           <div class="progress-widget">
                              <div class="rounded p-3 bg-soft-warning">
                                 <i class="fa fa-users"></i>
                              </div>
                              <div class="progress-detail">
                                 <p  class="mb-2">Cursos</p>
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
                                 <p  class="mb-2">Recetas</p>
                                 <h4 class="counter">1</h4>
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
      <div class="col-lg-12">
          <div class="row">
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">
                          <div id="calendar1" class="calendar-s"></div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection
