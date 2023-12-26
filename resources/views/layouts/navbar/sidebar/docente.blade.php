<aside class="sidebar sidebar-default sidebar-white sidebar-base navs-rounded-all ">
    <div class="sidebar-header d-flex align-items-center justify-content-start">
        <a href="{{ route('docente.home') }}" class="navbar-brand">
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
                    <a class="nav-link {{ Route::is('docente.home') ? 'active' : '' }}" aria-current="page" href="{{ route('docente.home') }}">
                        <i class="bi bi-house"></i>
                        <span class="item-name">Inicio</span>
                    </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ Route::is('chef.cursos') ? 'active' : '' }}" href="{{ route('chef.cursos') }}">
                    <i class="bi bi-bookshelf"></i>
                    <span class="item-name">Cursos</span>
                  </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-receta" role="button" aria-expanded="false" aria-controls="sidebar-receta">
                        <i class="bi bi-list"></i>
                        <span class="item-name">Recetas</span>
                        <i class="right-icon">
                            <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </i>
                    </a>
                    <ul class="sub-nav collapse" id="sidebar-receta" data-bs-parent="#sidebar-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.ingredientes') ? 'active' : '' }}" href="{{ route('admin.ingredientes') }}">
                                <i class="bi bi-basket icon"></i>
                                <i class="sidenav-mini-icon"> LR </i>
                                <span class="item-name">Lista Recetas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.recetas') ? 'active' : '' }}" href="{{ route('admin.recetas') }}">
                                <i class="bi bi-journals icon"></i>
                                <i class="sidenav-mini-icon"> AR </i>
                                <span class="item-name">Agregar Recetas</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li><hr class="hr-horizontal"></li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                          <i class="bi bi-postcard"></i>
                          <span class="item-name">Publicaciones</span>
                    </a>
                </li>
            </ul>
          </div>
    </div>
    <div class="sidebar-footer"></div>
  </aside>   