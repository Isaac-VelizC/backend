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
                    <p class="text-center">Ingrese una nueva contraseña.</p>
                    <form method="POST" action="{{ route('update.password.code') }}">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="user_id" value="{{ $user }}">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                                    <input id="confirm_password" type="password"
                                        class="form-control @error('confirm_password') is-invalid @enderror"
                                        name="confirm_password" required>
                                    @error('confirm_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-primary">Confirmar</button>
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