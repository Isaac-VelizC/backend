<div>
    <div class="position-relative iq-banner">
        <div class="iq-navbar-header" style="height: 150px;">
            <div class="container-fluid iq-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                            <div>
                            <h4>{{ Breadcrumbs::render($item->rol == 'P' ? 'Trabajadores.edit' : 'Docentes.edit' , $idDocente, $item) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-header-img">
                <img src="{{ asset('img/fondo1.jpg') }}" alt="header" class="img-fluid w-100 h-100 animated-scaleX">
            </div>
        </div> 
    </div>
    
    <div class="conatiner-fluid content-inner mt-n5 py-0">
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
        <div class="row">
            @if ($item->user)
                <div class="col-xl-3 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="user-profile">
                                @if (!$item->photo)
                                    <img src="{{ asset($item->photo) }}" alt="profile-img" class="rounded-pill avatar-130 img-fluid">
                                @else
                                    <img src="{{ asset('img/user.png') }}" alt="profile-img" class="rounded-pill avatar-130 img-fluid">
                                @endif
                                </div>
                                <div class="mt-3">
                                <p class="d-inline-block pl-3"> {{ $item->user->getRoleNames()->first() }}</p>

                                </div>
                                <span class="badge rounded-pill bg-danger text-white">Cambiar Rol</span>
                                <!--a href="{{ route('quita.role', $item->user->id ) }}">Quitar Rol</a-->
                            </div>
                            <form wire:submit.prevent='cambiarPassword'>
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">Contraseña:</label>
                                    <input type="password" class="form-control" wire:model="pass" placeholder="***********">
                                    @error('pass') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Confirmar Contraseña:</label>
                                    <input type="password" class="form-control" wire:model="passConfirm" placeholder="***********">
                                    @error('passConfirm') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="{{ $item->user ? 'col-xl-9 col-lg-8' : 'col-xl-12 col-lg-12'}}">
                <div class="card">
                    <div class="card-body">
                        <div class="new-user-info">
                            <form class="needs-validation" novalidate id="formHabilitarDesabilitar" wire:submit.prevent='update'>
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="form-label">Nombre de docente:</label>
                                        <input type="text" class="form-control" wire:model="docenteEdit.nombre" placeholder="Nombre" required>
                                        @error('docenteEdit.nombre') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="form-label">Apellido Paterno:</label>
                                        <input type="text" class="form-control" wire:model="docenteEdit.paterno" placeholder="Apellido Paterno" required>
                                        @error('docenteEdit.paterno') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="form-label">Apellido Materno:</label>
                                        <input type="text" class="form-control" wire:model="docenteEdit.materno" placeholder="Apellido Materno">
                                        @error('docenteEdit.materno') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="form-label">Cedula de Identidad:</label>
                                        <input type="text" class="form-control" wire:model="docenteEdit.cedula" placeholder="Cedula de Identidad" required>
                                        @error('docenteEdit.cedula') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label class="form-label">Genero:</label>
                                        <select wire:model="docenteEdit.genero" class="selectpicker form-control" data-style="py-0" required>
                                            <option value="" disabled>Seleccionar Género</option>
                                            <option value="Hombre" @if($item->genero == 'Hombre') selected @endif>Hombre</option>
                                            <option value="Mujer" @if($item->genero == 'Mujer') selected @endif>Mujer</option>
                                            <option value="Otro" @if($item->genero == 'Otro') selected @endif>Otro</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="form-label">Numero Celular:</label>
                                        <input type="text" class="form-control" wire:model="docenteEdit.telefono" placeholder="Numero de Celular" required>
                                        @error('docenteEdit.telefono') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="form-label">E-mail:</label>
                                        <input type="email" class="form-control" wire:model="docenteEdit.email" placeholder="E-mail" required>
                                        @error('docenteEdit.email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    @if ($item->rol == 'P')
                                        <div class="form-group col-md-4">
                                            <label class="form-label">Cargo:</label>
                                            <input type="text" class="form-control" wire:model="docenteEdit.cargo" placeholder="Cargo" required>
                                            @error('docenteEdit.cargo') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    @endif
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                        <a type="button" class="btn btn-danger" onclick="window.history.back()">Salir</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
