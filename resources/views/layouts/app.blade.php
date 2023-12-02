<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ 'IGLA' }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/hope-ui.min.css?v=2.0.0')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/hope-ui.css')}}" />
    <script>
        var baseUrl = {!! json_encode(url('/')) !!}
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @livewireStyles
</head>
<body>
    @if (auth()->check())
        @if (in_array('Admin', Auth::user()->getRoleNames()->toArray()))
            @include('layouts.navbar.sidebar.admin')
        @elseif (in_array('Docente', Auth::user()->getRoleNames()->toArray()))
            @include('layouts.navbar.sidebar.docente')
        @else
            @include('layouts.navbar.sidebar.estud')
        @endif
        <main class="main-content">
            @include('layouts.navbar.nav')
            @yield('content')
        </main>
    @else
        @yield('content')
    @endif
    
    @livewireScripts
    <script src="{{ asset('assets/js/core/libs.min.js')}}"></script>
    <script src="{{ asset('assets/js/core/external.min.js')}}"></script>
    <script src="{{ asset('assets/js/hope-ui.js')}}" defer></script>
    
</body>
</html>