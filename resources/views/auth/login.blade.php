@extends('layouts.app')

@section('content')
   <div class="row m-0 align-items-center bg-gray-300 vh-100">            
      <div class="col-md-6">
         <div class="row justify-content-center">
            <div class="col-md-10">
               <div class=" px-sm-2 px-4 px-lg-5">
                  <div class=" text-center navbar-brand mb-3 py-4">
                     <img src="{{ asset('img/igla-logo.png') }}" alt="log" width="300">
                  </div>
                  <p class="text-center">Inicie sesión para mantenerse conectado.</p>
                  <form method="POST" action="{{ route('login') }}">
                     @csrf
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="form-group">
                              <label for="email" class="form-label">Usuario</label>
                              <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required aria-describedby="email" autocomplete="email" autofocus>
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
                     <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-6 d-md-block d-none p-0 vh-100 overflow-hidden">
         <img src="{{ asset('assets/images/auth/login.jpg')}}" class="gradient-main rounded-5" alt="images">
      </div>
   </div>
@endsection
