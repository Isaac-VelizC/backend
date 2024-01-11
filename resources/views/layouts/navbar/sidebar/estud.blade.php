<aside class="sidebar sidebar-default sidebar-white sidebar-base navs-rounded-all ">
    <div class="sidebar-header d-flex align-items-center justify-content-start">
        <a href="{{ route('estudiante.home') }}" class="navbar-brand">
            <div class="logo-main">
                <div class="logo-normal">
                  <img src="{{ asset('img/igla.svg')}}" alt="logo" height="35">
                </div>
                <div class="logo-mini">
                  <img src="{{ asset('img/igla.svg')}}" alt="logo" height="35">
                </div>
            </div>
            <h4 class="logo-title">IGLA</h4>
        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </i>
        </div>
    </div>
    <div class="sidebar-body pt-0 data-scrollbar">
      <div class="sidebar-list">
        <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
          <li class="nav-item">
              <a class="nav-link {{ Route::is('estudiante.home') ? 'active' : '' }}" aria-current="page" href="{{ route('estudiante.home') }}">
                  <i class="bi bi-house"></i>
                  <span class="item-name">Inicio</span>
              </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Route::is('cursos.carrera') ? 'active' : '' }}" href="{{ route('cursos.carrera') }}">
              <i class="bi bi-bookshelf"></i>
              <span class="item-name">Materias</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Route::is('estudiante.calificaciones') ? 'active' : '' }}" href="{{ route('estudiante.calificaciones') }}">
              <i class="bi bi-journal-check"></i>
              <span class="item-name">Calificaciones</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="sidebar-footer"></div>
  </aside>   