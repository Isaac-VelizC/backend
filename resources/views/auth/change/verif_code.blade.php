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
                    <h4 class="text-center text-black">Ingrese el codigo.</h4>
                    <hr>
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
                    <form method="POST" action="{{ route('verify.code.pass') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="code" class="form-label">Codigo</label>
                                    <input id="code" type="text" placeholder="00000000"
                                        class="form-control @error('code') is-invalid @enderror" name="code"
                                        value="{{ old('code') }}" required>
                                    @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-primary">Enviar Codigo</button>
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