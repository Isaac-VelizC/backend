<aside class="sidebar sidebar-default sidebar-white sidebar-base navs-rounded-all ">
    <div class="sidebar-header d-flex align-items-center justify-content-start">
        <a href="{{ route('admin.home') }}" class="navbar-brand">
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
                    <a class="nav-link {{ Route::is('admin.home') ? 'active' : '' }}" aria-current="page" href="{{ route('admin.home') }}">
                        <i class="bi bi-house"></i>
                        <span class="item-name">Inicio</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#horizontal-menu" role="button" aria-expanded="false" aria-controls="horizontal-menu">
                        <i class="bi bi-people"></i>
                        <span class="item-name">Usuarios</span>
                        <i class="right-icon">
                            <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </i>
                    </a>
                    <ul class="sub-nav collapse" id="horizontal-menu" data-bs-parent="#sidebar-menu">
                        @can('GestionEstudiante')
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.estudinte') ? 'active' : '' }}" href="{{ route('admin.estudinte') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> E </i>
                                    <span class="item-name">Estudiantes</span>
                                </a>
                            </li>
                        @endcan
                        @can('GestionDocente')
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.docentes') ? 'active' : '' }}" href="{{ route('admin.docentes') }}">
                                    <i class="icon svg-icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> D </i>                   
                                    <span class="item-name">Docentes</span>
                                </a>
                            </li>
                        @endcan
                        @can('GestionUsers')
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.personal') ? 'active' : '' }}" href="{{ route('admin.personal') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> P </i>
                                    <span class="item-name">Personal</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @can('GestionCurso')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('admin.cursos.activos') ? 'active' : '' }}" href="{{ route('admin.cursos.activos') }}">
                            <i class="bi bi-bookshelf"></i>
                            <span class="item-name">Cursos</span>
                        </a>
                    </li>
                @endcan
                @can('Informes')
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-user" role="button" aria-expanded="false" aria-controls="sidebar-user">
                            <i class="bi bi-journal-check"></i>
                            <span class="item-name">Reportes</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="sidebar-user" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.estudiantes.informe') ? 'active' : '' }}" href="{{ route('admin.estudiantes.informe') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> U </i>
                                    <span class="item-name">Estudiantes</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.asistencias.informe') ? 'active' : '' }}" href="{{ route('admin.asistencias.informe') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> A </i>
                                    <span class="item-name">Asistencias</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.materias.informe') ? 'active' : '' }}" href="{{ route('admin.materias.informe')}}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> M </i>
                                    <span class="item-name">Materias</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.pagos.informe') ? 'active' : '' }}" href="{{ route('admin.pagos.informe')}}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> P </i>
                                    <span class="item-name">Pagos</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                    @can('GestionPagos')
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.lista.pagos') ? 'active' : '' }}" href="{{ route('admin.lista.pagos') }}">
                                <i class="bi bi-receipt"></i>
                                <span class="item-name">Pagos</span>
                            </a>
                        </li>
                    @endcan
                    @can('GestionCalendario')
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.calendario') ? 'active' : '' }}" href="{{ route('admin.calendario') }}">
                                <i class="bi bi-calendar"></i>
                                <span class="item-name">Calendario</span>
                            </a>
                        </li>
                    @endcan
                    @can('EvaluacionDocente')
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('materia.evaluacion.docente') ? 'active' : '' }}" href="{{ route('materia.evaluacion.docente') }}">
                                <i class="bi bi-list-task"></i>
                                <span class="item-name">Evaluación Docente</span>
                            </a>
                        </li>
                    @endcan
                    @can('GestionInventario')
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.gestion.inventario') ? 'active' : '' }}" href="{{ route('admin.gestion.inventario') }}">
                                <i class="bi bi-basket"></i>
                                <span class="item-name">Inventario Ingredientes</span>
                            </a>
                        </li>
                    @endcan
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
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> LR </i>
                                    <span class="item-name">Lista Recetas</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.recetas') ? 'active' : '' }}" href="{{ route('admin.recetas') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> AR </i>
                                    <span class="item-name">Agregar Recetas</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                  <li><hr class="hr-horizontal"></li>
                  @role('Admin')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('admin.administracion') ? 'active' : '' }}" href="{{ route('admin.administracion') }}">
                            <i class="bi bi-person-exclamation"></i>
                            <span class="item-name">Administración</span>
                        </a>
                    </li>
                  @endrole
              </ul>
          </div>
      </div>
      <div class="sidebar-footer"></div>
  </aside>