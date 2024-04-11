<div>
    <div class="iq-navbar-header" style="height: 120px;"></div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
               <div class="d-flex flex-wrap align-items-center justify-content-between">
                  <div class="d-flex flex-wrap align-items-center">
                     <div class="profile-img position-relative me-3 mb-3 mb-lg-0 profile-logo profile-logo1">
                        <a href="{{ asset($info->photo != 'user.jpg' ? 'storage/' . $info->photo : '#') }}">
                            <img src="{{ asset($info->photo != 'user.jpg' ? 'storage/' . $info->photo : 'img/user.jpg') }}" alt="User-Profile" class="theme-color-default-img img-fluid rounded-pill avatar-100">
                        </a>
                    </div>
                    <div class="d-flex flex-wrap align-items-center mb-3 mb-sm-0">
                        <h4 class="me-2 h4">{{$info->nombre}} {{$info->ap_paterno}} {{$info->ap_materno}}</h4>
                        <span> - {{ $user->getRoleNames()->first() }}</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="{{ $Rolestudiante ? 'col-lg-5' : 'col-lg-6'}}">
         @if(session('success'))
            <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
               <span>{{ session('success') }}</span>
               <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
         @endif
         @if(session('error'))
            <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
               <span>{{ session('error') }}</span>
               <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
         @endif
             <div class="card">
               <div class="card-header">
                  <div class="header-title">
                     <h4 class="card-title">Información Personal</h4>
                  </div>
               </div>
                  <div class="card-body">
                     <div class="text-center">
                        <div class="user-profile position-relative">
                            <img src="{{ asset($info->photo != 'user.jpg' ? 'storage/' . $info->photo : 'img/user.jpg') }}" alt="profile-img" class="rounded-pill avatar-130 img-fluid">
                            <form class="needs-validation" novalidate wire:submit.prevent='updatedPerfil'>
                                <label class="upload-icone-portada bg-primary">
                                    <input wire:model="perfil" class="file-upload" type="file" id="customFile" accept="image/*">
                                    <svg class="upload-button icon-14" width="14" viewBox="0 0 24 24">
                                        <path fill="#ffffff" d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z" />
                                    </svg>
                                </label>
                                @error('perfil') <span class="text-danger">{{ $message }}</span> @enderror
                           </form>
                        </div>
                        <div class="mt-3">
                           <p class="d-inline-block pl-3"> {{ $user->getRoleNames()->first() }}</p>
                        </div>
                     </div>
                     <div class="form-group">
                        <ul class="list-group list-group-flush">
                           <li class="list-group-item d-flex justify-content-between align-items-start">
                              <div class="fw-bold">Nombre</div>
                              <span>{{ $info->nombre }} {{$info->ap_paterno}} {{$info->ap_materno}}</span>
                           </li>
                           <li class="list-group-item d-flex justify-content-between align-items-start">
                              <div class="fw-bold">Cedula de Identidad</div>
                              <span>{{ $info->ci }}</span>
                           </li>
                           @if ($Rolestudiante)
                              <li class="list-group-item d-flex justify-content-between align-items-start">
                                 <div class="fw-bold">Fecha nacimiento</div>
                                 <span>{{ $info->estudiante->fecha_nacimiento }}</span>
                              </li>
                           @endif
                           <li class="list-group-item d-flex justify-content-between align-items-start">
                              <div class="fw-bold">Genero</div>
                              <span>{{ $info->genero }}</span>
                           </li>
                           @if ($Rolestudiante)
                              <li class="list-group-item d-flex justify-content-between align-items-start">
                                 <div class="fw-bold">Domicilio</div>
                                 <span>{{ $info->estudiante->direccion }}</span>
                              </li>
                           @endif
                        </ul>
                     </div>
                  </div>
               </div>
               @if ($Rolestudiante)
                  <div class="card">
                     <div class="card-header">
                        <div class="header-title">
                           <h4 class="card-title">Información de Contacto</h4>
                        </div>
                     </div>
                     <div class="card-body">
                        <ul class="list-group list-group-flush">
                           <li class="list-group-item d-flex justify-content-between align-items-start">
                              <div class="fw-bold">E-mail</div>
                              <span>{{ $user->email }}</span>
                           </li>
                           <li class="list-group-item d-flex justify-content-between align-items-start">
                              <div class="fw-bold">Celular</div>
                              <span>{{ $info->numero }}</span>
                           </li>
                           <li class="list-group-item d-flex justify-content-between align-items-start">
                              <div class="fw-bold">Referencia</div>
                              <span>{{ $famil ? $famil->numero : 'No tiene' }}</span>
                           </li>
                        </ul>
                     </div>
                  </div>
               @endif
          </div>
            @if ($Rolestudiante)
            <div class="col-lg-4">
               <div class="card">
                  <div class="card-header">
                     <div class="header-title">
                        <h4 class="card-title">Información Academica</h4>
                     </div>
                  </div>
                     <div class="card-body">
                        <div class="form-group">
                           <ul class="list-group list-group-flush">
                              <li class="list-group-item d-flex justify-content-between align-items-start">
                                 <div class="fw-bold">Carrera</div>
                                 <span>Gastronomia</span>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-start">
                                 <div class="fw-bold">Sigla</div>
                                 <span>LG</span>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-start">
                                 <div class="fw-bold">Titulo académico</div>
                                 <span>Licenciatura</span>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-start">
                                 <div class="fw-bold">Inicio</div>
                                 <span>{{ $info->estudiante->created_at->toDateString() }}</span>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-start">
                                 <div class="fw-bold">Turno</div>
                                 <span>Mañana</span>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-start">
                                 <div class="fw-bold">Estado</div>
                                 <span>{{ $info->estudiante->estado == true ? 'Vigente' : 'Inactivo' }}</span>
                              </li>
                           </ul>
                        </div>
                     </div>
               </div>
            </div>
            @endif
          <div class="{{ $Rolestudiante ? 'col-lg-3' : 'col-lg-6'}}">
             <div class="card">
               <div class="card-header">
                  <div class="header-title">
                     <h4 class="card-title">Restablecer Contraseña</h4>
                  </div>
               </div>
               <div class="card-body">
                  <form>
                     @csrf
                      <div class="form-group">
                         <label class="form-label" for="pass">Contraseña:</label>
                         <input type="password" class="form-control" name="pass" id="pass" placeholder="***********">
                      </div>
                      <div class="form-group">
                         <label class="form-label" for="passConfirm">Confirmar Contraseña:</label>
                         <input type="password" class="form-control" name="passConfirm" id="passConfirm" placeholder="***********">
                      </div>
                      @if ($errors->has('passConfirm'))
                        <span class="text-danger">{{ $errors->first('passConfirm') }}</span>
                     @endif
                      <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                   </form>
               </div>
             </div>
          </div>
      </div>
</div>
</div>
