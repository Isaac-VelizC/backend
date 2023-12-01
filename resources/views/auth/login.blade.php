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
                         <a href="../../dashboard/index.html" class="navbar-brand d-flex align-items-center mb-3">
                            <div class="logo-main">
                                <div class="logo-normal">
                                    <svg class="text-primary icon-30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2" transform="rotate(-45 -0.757324 19.2427)" fill="currentColor"/>
                                        <rect x="7.72803" y="27.728" width="28" height="4" rx="2" transform="rotate(-45 7.72803 27.728)" fill="currentColor"/>
                                        <rect x="10.5366" y="16.3945" width="16" height="4" rx="2" transform="rotate(45 10.5366 16.3945)" fill="currentColor"/>
                                        <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2" transform="rotate(45 10.5562 -0.556152)" fill="currentColor"/>
                                    </svg>
                                </div>
                                <div class="logo-mini">
                                    <svg class="text-primary icon-30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2" transform="rotate(-45 -0.757324 19.2427)" fill="currentColor"/>
                                        <rect x="7.72803" y="27.728" width="28" height="4" rx="2" transform="rotate(-45 7.72803 27.728)" fill="currentColor"/>
                                        <rect x="10.5366" y="16.3945" width="16" height="4" rx="2" transform="rotate(45 10.5366 16.3945)" fill="currentColor"/>
                                        <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2" transform="rotate(45 10.5562 -0.556152)" fill="currentColor"/>
                                    </svg>
                                </div>
                            </div>
                            <h4 class="logo-title ms-3">INSTITUTO TÉCNICO IGLA</h4>
                         </a>
                         <h2 class="mb-2 text-center">Inicia sesión</h2>
                         <p class="text-center">Inicie sesión para mantenerse conectado.</p>
                         <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row">
                               <div class="col-lg-12">
                                  <div class="form-group">
                                     <label for="email" class="form-label">Email</label>
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
                                     <label for="password" class="form-label">Password</label>
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
                                     <label class="form-check-label" for="customCheck1">Recocuerdame</label>
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
                            <p class="text-center my-3">¿O iniciar sesión con otras cuentas?</p>
                            <div class="d-flex justify-content-center">
                               <ul class="list-group list-group-horizontal list-group-flush">
                                  <li class="list-group-item border-0 pb-0">
                                     <a href="#"><img src="../../assets/images/brands/fb.svg" alt="fb"></a>
                                  </li>
                                  <li class="list-group-item border-0 pb-0">
                                     <a href="#"><img src="../../assets/images/brands/gm.svg" alt="gm"></a>
                                  </li>
                               </ul>
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
