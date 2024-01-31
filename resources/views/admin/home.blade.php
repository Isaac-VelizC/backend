@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 80px;"></div> 
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
     <div class="col-md-12 col-lg-12">
        <div class="row row-cols-1">
           <div class="overflow-hidden d-slider1 ">
              <ul  class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                  @role('Admin')
                     <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                        <a href="{{ route('admin.users') }}">
                           <div class="card-body">
                              <div class="progress-widget">
                                    <div class="rounded p-3 bg-soft-primary">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                          <path d="M10.644 17.08c2.866-.662 4.539-1.241 3.246-3.682-3.932-7.427-1.042-11.398 3.111-11.398 4.235 0 7.054 4.124 3.11 11.398-1.332 2.455.437 3.034 3.242 3.682 2.483.574 2.647 1.787 2.647 3.889v1.031h-18c0-2.745-.22-4.258 2.644-4.92zm-12.644 4.92h7.809c-.035-8.177 3.436-5.313 3.436-11.127 0-2.511-1.639-3.873-3.748-3.873-3.115 0-5.282 2.979-2.333 8.549.969 1.83-1.031 2.265-3.181 2.761-1.862.43-1.983 1.34-1.983 2.917v.773z"/>
                                       </svg>
                                    </div>
                                    <div class="progress-detail">
                                       <p  class="mb-2">Total de Usuarios</p>
                                       <h4 class="counter">{{ count($users) }}</h4>
                                    </div>
                              </div>
                           </div>
                        </a>
                     </li>
                 @endrole
                 <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                     <a href="{{ route('admin.estudinte') }}">
                        <div class="card-body">
                           <div class="progress-widget">
                                 <div class="rounded p-3 bg-soft-success">
                                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                       <path d="M4.861 9.713c-.131-.146-.242-.299-.33-.459v-3.181l7.107 3.804 7.852-3.298v2.675c-.074.15-.169.294-.284.431.342.948.392 2.073.399 2.623 1.229-.437 2.398.593 2.398 2.492 0 3.208-2.462 4.017-2.561 4.053-2.414 4.776-6.276 5.147-7.404 5.147-1.128 0-4.99-.372-7.403-5.147-.1-.036-2.563-.845-2.563-4.061 0-2.003 1.289-2.917 2.4-2.48.007-.551.056-1.659.389-2.599zm13.52.669c-1.62 1.032-4.431 1.524-6.371 1.524-2.107 0-4.736-.501-6.319-1.508-.156.621-.241 1.298-.241 2.033 0 .528-.425.918-.897.918-.121 0-.244-.026-.365-.08-.06-.029-.152-.051-.256-.051-.112 0-.236.026-.344.099-.898.595-.804 3.838 1.393 4.598.219.076.403.238.509.451 2.16 4.299 5.557 4.634 6.548 4.634.99 0 4.389-.335 6.547-4.634.108-.213.291-.375.51-.451 2.197-.76 2.291-4.003 1.393-4.598-.365-.245-.632.032-.964.032-.472 0-.898-.388-.898-.918 0-.741-.085-1.424-.245-2.049zm4.619-.373h-2.99l1.012-2.002-.015-3.142-9.316 3.907-9.691-5.12 10.451-3.651 9.552 4.446v3.56l.997 2.002z"/>
                                    </svg>
                                 </div>
                                    <div class="progress-detail">
                                       <p  class="mb-2">Estudiantes</p>
                                       <h4 class="counter">{{ count($estudiantes) }}</h4>
                                    </div>
                           </div>
                        </div>
                     </a>
                 </li>
                 <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="900">
                     <a href="{{ route('admin.docentes') }}">
                        <div class="card-body">
                           <div class="progress-widget">
                                 <div class="rounded p-3 bg-soft-danger">
                                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                       <path d="M9 23h-6v-7.988c.517.217 1.134.384 1.938.484.274.034.524-.16.558-.434.034-.274-.16-.524-.434-.558-4.81-.603-5.062-5.307-5.062-6.004 0-3.587 2.913-6.5 6.5-6.5.788 0 1.543.141 2.242.397.82-.86 1.977-1.397 3.258-1.397s2.438.537 3.258 1.397c.699-.256 1.454-.397 2.242-.397 3.587 0 6.5 2.913 6.5 6.5 0 .691-.252 5.401-5.062 6.004-.274.034-.468.284-.434.558.034.274.284.468.558.434.804-.1 1.421-.267 1.938-.484v7.988h-6v-3.5c0-.311-.26-.5-.5-.5-.239 0-.5.189-.5.5v3.5h-4v-3.5c0-.311-.26-.5-.5-.5-.239 0-.5.189-.5.5v3.5z"/>
                                    </svg>
                                 </div>
                                 <div class="progress-detail">
                                    <p  class="mb-2">Docentes</p>
                                    <h4 class="counter">{{ count($docentes) }}</h4>
                                 </div>
                           </div>
                        </div>
                     </a>
                 </li>
                 <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1000">
                     <a href="{{ route('admin.inscripcion') }}">
                        <div class="card-body">
                           <div class="progress-widget">
                                 <div class="rounded p-3 bg-soft-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                       <path d="M12.408 13.032c1.158-.062 2.854-.388 4.18-1.128.962-1.478 1.598-2.684 2.224-4-.86.064-1.852-.009-2.736-.257 1.068-.183 2.408-.565 3.422-1.216 1.255-1.784 2.185-4.659 2.502-6.429-2.874-.048-5.566.89-7.386 2.064-.614.7-1.146 2.389-1.272 3.283-.277-.646-.479-1.68-.242-2.542-1.458.767-2.733 1.643-4.177 2.86-.72 1.528-.834 3.29-.768 4.276-.391-.553-.915-1.63-.842-2.809-2.59 2.504-4.377 5.784-2.682 9.324 1.879-1.941 4.039-3.783 5.354-4.639-3.036 3.474-5.866 8.047-7.985 12.181l2.504-.786c1.084-1.979 2.059-3.684 2.933-4.905 3.229.423 6.096-2.168 8.028-4.795-.77.19-2.246-.058-3.057-.482z"/>
                                    </svg>
                                 </div>
                                 <div class="progress-detail">
                                    <p  class="mb-2">Inscribir</p>
                                 </div>
                           </div>
                        </div>
                     </a>
                 </li>
                 @role('Admin')
                  <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1100">
                     <div class="card-body">
                        <div class="progress-widget">
                              <div class="rounded p-3 bg-soft-primary">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M24 7v-2c0-2.761-2.238-5-5-5h-14c-2.761 0-5 2.239-5 5v2h10v2h-10v6h4v2h-4v2c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-2h-8v-2h8v-6h-5v-2h5zm-16 11c0 .552-.447 1-1 1s-1-.448-1-1v-4c0-.552.447-1 1-1s1 .448 1 1v4zm3 0c0 .552-.447 1-1 1s-1-.448-1-1v-4c0-.552.447-1 1-1s1 .448 1 1v4zm3 0c0 .552-.447 1-1 1s-1-.448-1-1v-4c0-.552.447-1 1-1s1 .448 1 1v4zm0-8c0 .552-.447 1-1 1s-1-.448-1-1v-4c0-.552.447-1 1-1s1 .448 1 1v4zm3 0c0 .552-.447 1-1 1s-1-.448-1-1v-4c0-.552.447-1 1-1s1 .448 1 1v4z"/>
                                 </svg>
                              </div>
                              <a href="{{ route('admin.cursos') }}">
                                 <div class="progress-detail">
                                    <p  class="mb-2">Materias</p>
                                 <h4 class="counter">{{ count($materias) }}</h4>
                              </div>
                              </a>
                        </div>
                     </div>
                  </li>
                 @endrole
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
