@extends('layouts.app')

@section('content')

<div class="wrapper">
    <section class="login-content">
       <div class="row m-0 align-items-center bg-white vh-100">            
          <div class="col-md-6">
             <div class="row justify-content-center">
                <div class="col-md-10">
                   <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                      <div class="card-body">
                         <div class="navbar-brand mb-3">
                            <h4 class="logo-title text-center"><b>INSTITUTO TECNICO IGLA</b></h4>
                         </div>
                         <h2 class="mb-2 text-center">Inicia sesión</h2>
                         <p class="text-center">Inicie sesión para mantenerse conectado.</p>
                         <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row">
                               <div class="col-lg-12">
                                  <div class="form-group">
                                     <label for="email" class="form-label">Usuario</label>
                                     <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required aria-describedby="email" autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                  </div>
                               </div>
                               <div class="col-lg-12">
                                  <div class="form-group">
                                     <label for="password" class="form-label">Contraseña</label>
                                     <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" aria-describedby="password" required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                  </div>
                               </div>
                               <div class="col-lg-12 d-flex justify-content-between">
                                  <div class="form-check mb-3">
                                     <input class="form-check-input" type="checkbox" name="remember" id="customCheck1" {{ old('remember') ? 'checked' : '' }}>
                                     <label class="form-check-label" for="customCheck1">Recuerdame</label>
                                  </div>
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('¿Olvidaste la contraseña?') }}
                                        </a>
                                    @endif
                               </div>
                            </div>
                            <div class="d-flex justify-content-center">
                               <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                         </form>
                      </div>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
             <img src="{{ asset('assets/images/auth/login.jpg')}}" class="gradient-main animated-scaleX" alt="images">
          </div>
       </div>
    </section>
</div>
@endsection
