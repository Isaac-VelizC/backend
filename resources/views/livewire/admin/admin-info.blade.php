<div>
    <div class="position-relative iq-banner">
        <div class="iq-navbar-header" style="height: 200px;">
            <div class="container-fluid iq-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                            <div>                          
                                <h4>{{ Breadcrumbs::render('Gestionar') }}</h4>
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
        @if(session('message'))
            <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
                <span>{{ session('message') }}</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Horarios</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent='formHorario'>
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <input type="text" class="form-control" wire:model='horariosEdit.turno' placeholder="Ingrese un nombre">
                                    @error('horariosEdit.turno') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="time" wire:model='horariosEdit.inicio' class="form-control">
                                    @error('horariosEdit.inicio') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="time" wire:model='horariosEdit.fin' class="form-control">
                                    @error('horariosEdit.fin') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm">{{ $idHora != ''  ? 'Actualizar' : 'Guardar' }}</button>
                                <button type="button" class="btn btn-danger btn-sm" wire:click='resetForm'>cancel</button>
                            </div>
                        </form>
                        <hr>
                        <ol class="list-group list-group-numbered">
                            @if (count($horarios) > 0)
                                @foreach ($horarios as $hora)
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto" wire:click='seleccionarHorario({{$hora->id}})'>
                                            <div class="fw-bold">{{ $hora->turno }}</div>
                                            {{ $hora->inicio }} - {{ $hora->fin }}
                                        </div>
                                        <span class="badge bg-ligth btn" wire:click='borrarHorario({{$hora->id}})'><i class="bi bi-trash text-danger"></i></span>
                                    </li>
                                @endforeach
                            @else
                                <div class="text center">
                                    <p>No hay horarios</p>
                                </div>
                            @endif
                        </ol>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Metodo de Pago</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent='formMetodo'>
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="text" class="form-control" wire:model='metodoPagoEdit' placeholder="Nombre de metodo de pago">
                                    @error('metodoPagoEdit') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="number" class="form-control" wire:model='metodoMontoEdit' placeholder="Monto">
                                    @error('metodoMontoEdit') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm">{{ $idMetodo != ''  ? 'Actualizar' : 'Guardar' }}</button>
                                <button type="submit" class="btn btn-danger btn-sm" wire:click='resetForm'>cancel</button>
                            </div>
                        </form>
                        <hr>
                        <ol class="list-group list-group-numbered">
                            @if (count($metodoPagos) > 0)
                                @foreach ($metodoPagos as $metodo)
                                    <li class="list-group-item d-flex justify-content-between align-items-start" @if (!$metodo->estado) style="opacity: 0.5;" @endif >
                                        <div class="ms-2 me-auto" wire:click='seleccionarMetodo({{$metodo->id}})'>
                                            <div class="fw-bold">{{ $metodo->nombre }} - {{ $metodo->monto }}bs.</div>
                                        </div>
                                        <div>
                                        @if ( $metodo->id != 1 )
                                            <span class="badge bg-ligth btn" wire:click='eliminarMetodo({{$metodo->id}})'><i class="bi bi-trash text-danger"></i></span>
                                        @endif
                                            <span class="badge bg-ligth btn" wire:click='inhabilitarMetodo({{$metodo->id}})'><i class="bi bi-x-circle text-danger"></i></span>        
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <div class="text center">
                                    <p>No hay metodos de pago</p>
                                </div>
                            @endif
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Aulas</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" wire:submit.prevent='formAula' novalidate>
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <input type="text" class="form-control" wire:model='aulasEdit.nombre' placeholder="Nombre" required>
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" class="form-control" wire:model='aulasEdit.codigo' placeholder="Codigo" required>
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="number" class="form-control" wire:model='aulasEdit.capacidad' placeholder="Capacidad" required>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm">{{ $idAula != ''  ? 'Actualizar' : 'Guardar' }}</button>
                                <button type="button" class="btn btn-danger btn-sm" wire:click='resetForm'>cancelar</button>
                            </div>
                        </form>
                        <hr>
                        <ol class="list-group list-group-numbered">
                            @if (count($aulas) > 0)
                                @foreach ($aulas as $aula)
                                    <li class="list-group-item d-flex justify-content-between align-items-start" @if (!$aula->estado) style="opacity: 0.5;" @endif >
                                        <div class="ms-2 me-auto" wire:click='seleccionarAula({{ $aula->id }})'>
                                            <div class="fw-bold">{{ $aula->nombre }}</div>
                                            <p> <span class="text-darck">Codigo:</span> {{ $aula->codigo }}</p>
                                        </div>
                                        <div class="align-items-center">
                                            <span class="badge bg-primary rounded-pill">{{ $aula->capacidad }}</span>
                                            <span class="badge bg-ligth btn" wire:click='borrarAula({{$aula->id}})'><i class="bi bi-trash text-danger"></i></span>
                                            <span class="badge bg-ligth btn" wire:click='inhabilitarAula({{$aula->id}})'><i class="bi bi-x-circle text-danger"></i></span>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <div class="text center">
                                    <p>No hay aulas</p>
                                </div>
                            @endif
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>