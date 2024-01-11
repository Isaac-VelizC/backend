<nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
      <div class="container-fluid navbar-inner">
        <a href="{{ url('/') }}" class="navbar-brand">
            <div class="logo-main">
                <div class="logo-normal">
                  <img src="{{ asset('img/igla.svg')}}" alt="logo" height="30">
                </div>
                <div class="logo-mini">
                  <img src="{{ asset('img/igla.svg')}}" alt="logo" height="30">
                </div>
            </div>
            <h4 class="logo-title">IGLA</h4>
        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
             <svg  width="20px" class="icon-20" viewBox="0 0 24 24">
                <path fill="currentColor" d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
            </svg>
            </i>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon">
              <span class="mt-2 navbar-toggler-bar bar1"></span>
              <span class="navbar-toggler-bar bar2"></span>
              <span class="navbar-toggler-bar bar3"></span>
            </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
            <li class="nav-item dropdown">
              <a href="#"  class="nav-link" id="notification-drop" data-bs-toggle="dropdown" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                  <path d="M15.137 3.945c-.644-.374-1.042-1.07-1.041-1.82v-.003c.001-1.172-.938-2.122-2.096-2.122s-2.097.95-2.097 2.122v.003c.001.751-.396 1.446-1.041 1.82-4.667 2.712-1.985 11.715-6.862 13.306v1.749h20v-1.749c-4.877-1.591-2.195-10.594-6.863-13.306zm-3.137-2.945c.552 0 1 .449 1 1 0 .552-.448 1-1 1s-1-.448-1-1c0-.551.448-1 1-1zm3 20c0 1.598-1.392 3-2.971 3s-3.029-1.402-3.029-3h6z"/>
                </svg>
                <span class="bg-danger dots"></span>
              </a>
              <div class="p-0 sub-drop dropdown-menu dropdown-menu-end" aria-labelledby="notification-drop">
                  <div class="m-0 shadow-none card">
                    <div class="py-3 card-header d-flex justify-content-between bg-primary">
                        <div class="header-title">
                          <h5 class="mb-0 text-white">Todas las Notificaciones</h5>
                        </div>
                    </div>
                    <div class="p-0 card-body">
                        <a href="#" class="iq-sub-card">
                          <div class="d-flex align-items-center">
                              <img class="p-1 avatar-40 rounded-pill bg-soft-primary" src="" alt="">
                              <div class="ms-3 w-100">
                                <h6 class="mb-0 ">Emma Watson Bni</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-0">95 MB</p>
                                    <small class="float-end font-size-12">Just Now</small>
                                </div>
                              </div>
                          </div>
                        </a>
                    </div>
                  </div>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a href="#" class="nav-link" id="mail-drop" data-bs-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                  <path d="M0 3v18h24v-18h-24zm22 16l-6.526-6.618-3.445 3.483-3.418-3.525-6.611 6.66 5.051-8-5.051-6 10.029 7.446 9.971-7.446-4.998 6.01 4.998 7.99z"/>
                </svg>
                <span class="bg-primary count-mail"></span>
              </a>
              <div class="p-0 sub-drop dropdown-menu dropdown-menu-end" aria-labelledby="mail-drop">
                  <div class="m-0 shadow-none card">
                    <div class="py-3 card-header d-flex justify-content-between bg-primary">
                        <div class="header-title">
                          <h5 class="mb-0 text-white">Todos los Mensajes</h5>
                        </div>
                    </div>
                    <div class="p-0 card-body ">
                        <a href="#" class="iq-sub-card">
                          <div class="d-flex align-items-center">
                              <div class="">
                                <img class="p-1 avatar-40 rounded-pill bg-soft-primary" src="" alt="">
                              </div>
                              <div class="ms-3">
                                <h6 class="mb-0 ">Bni Emma Watson</h6>
                                <small class="float-start font-size-12">13 Jun</small>
                              </div>
                          </div>
                        </a>
                    </div>
                  </div>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset(Auth::user()->persona->photo != 'user.jpg' ? 'storage/' . Auth::user()->persona->photo : 'img/user.jpg') }}" alt="User-Profile" class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                <div class="caption ms-3 d-none d-md-block ">
                  <h6 class="mb-0 caption-title">{{ Auth::user()->name }}</h6>
                      @foreach(Auth::user()->getRoleNames()->toArray() as $role)
                        <p class="mb-0 caption-sub-title">{{ $role }}</p>
                      @endforeach
                </div>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li>
                  <a class="dropdown-item" href="{{ route('users.profile') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                      <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm7.753 18.305c-.261-.586-.789-.991-1.871-1.241-2.293-.529-4.428-.993-3.393-2.945 3.145-5.942.833-9.119-2.489-9.119-3.388 0-5.644 3.299-2.489 9.119 1.066 1.964-1.148 2.427-3.393 2.945-1.084.25-1.608.658-1.867 1.246-1.405-1.723-2.251-3.919-2.251-6.31 0-5.514 4.486-10 10-10s10 4.486 10 10c0 2.389-.845 4.583-2.247 6.305z"/>
                    </svg>
                    Ver Perfil
                  </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                      <path d="M8 10v-5l8 7-8 7v-5h-8v-4h8zm2-8v2h12v16h-12v2h14v-20h-14z"/>
                    </svg>
                    Salir
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
</nav>