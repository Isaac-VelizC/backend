<nav class="nav navbar navbar-expand-lg navbar-light iq-navbar"z>
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
              <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset(Auth::user()->persona->photo != 'user.png' ? 'storage/' . Auth::user()->persona->photo : 'img/user.png') }}" alt="User-Profile" 
                style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                <div class="caption ms-3 d-none d-md-block ">
                  <h6 class="mb-0 caption-title">{{ Auth::user()->persona->nombre }} {{ Auth::user()->persona->ap_paterno }}</h6>
                      @foreach(Auth::user()->getRoleNames()->toArray() as $role)
                        <p class="mb-0 caption-sub-title">{{ $role }}</p>
                      @endforeach
                </div>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li>
                  <a class="dropdown-item" href="{{ route('users.profile') }}">
                    <i class="bi bi-person-circle"></i>
                    Ver Perfil
                  </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>
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