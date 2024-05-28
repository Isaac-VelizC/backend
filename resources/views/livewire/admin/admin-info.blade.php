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
                                    <input type="text" class="form-control" wire:model='metodoPagoEdit' placeholder="Ingrese un metodo de pago">
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" class="form-control" wire:model='metodoMontoEdit' placeholder="Ingrese el monto">
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
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto" wire:click='seleccionarMetodo({{$metodo->id}})'>
                                            <div class="fw-bold">{{ $metodo->nombre }} - {{ $metodo->monto }}bs.</div>
                                        </div>
                                        @if ( $metodo->id != 1 )
                                            <span class="badge bg-ligth btn" wire:click='eliminarMetodo({{$metodo->id}})'><i class="bi bi-trash text-danger"></i></span>
                                        @endif
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
                        <form wire:submit.prevent='formAula'>
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <input type="text" class="form-control" wire:model='aulasEdit.nombre' placeholder="Nombre">
                                </div>
                                <div class="form-group col-lg-6">
                                    <select type="text" class="form-select" wire:model='aulasEdit.tipo' placeholder="Tipo de Aula">
                                        <option value="1">Teorico</option>
                                        <option value="2" selected>Practico</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                    <input type="text" class="form-control" wire:model='aulasEdit.codigo' placeholder="Codigo">
                                </div>
                                <div class="form-group col-lg-3">
                                    <input type="numeric" class="form-control" wire:model='aulasEdit.capacidad' placeholder="Capacidad">
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
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto" wire:click='seleccionarAula({{ $aula->id }})'>
                                            <div class="fw-bold">{{ $aula->nombre }}</div>
                                            <p> <span class="text-darck">Codigo:</span> {{ $aula->codigo }}</p>
                                        </div>
                                        <div class="align-items-center">
                                            <span class="badge bg-primary rounded-pill">{{ $aula->capacidad }}</span>
                                            <span class="badge bg-ligth btn" wire:click='borrarAula({{$aula->id}})'><i class="bi bi-trash text-danger"></i></span>
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