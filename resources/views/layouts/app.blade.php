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
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css')}}"/>

    <!--link rel="stylesheet" href="{{ asset('assets/css/custom.min.css?v=2.0.0')}}" /-->
    <!--link rel="stylesheet" href="{{ asset('assets/css/dark.min.css')}}"/-->
    <!--link rel="stylesheet" href="{{ asset('assets/css/customizer.min.css')}}" /-->
    <!--link rel="stylesheet" href="{{ asset('assets/css/rtl.min.css')}}"/-->
    

    <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/core/main.css')}}' />
    <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/daygrid/main.css')}}' />
    <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/timegrid/main.css')}}' />
    <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/list/main.css')}}' />
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
    @yield('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script src="{{ asset('assets/js/core/libs.min.js')}}"></script>
    <script src="{{ asset('assets/js/core/external.min.js')}}"></script>
    <script src="{{ asset('assets/js/charts/widgetcharts.js')}}"></script>
    <script src="{{ asset('assets/js/charts/vectore-chart.js')}}"></script>
    <script src="{{ asset('assets/js/charts/dashboard.js')}}" ></script>
    <script src="{{ asset('assets/js/plugins/slider-tabs.js')}}"></script>
    <script src="{{ asset('assets/js/hope-ui.js')}}" defer></script>
    <script src='{{ asset('assets/vendor/fullcalendar/core/main.js')}}'></script>
    <script src='{{ asset('assets/vendor/fullcalendar/core/locales/es.js')}}'></script>
    <script src='{{ asset('assets/vendor/fullcalendar/daygrid/main.js')}}'></script>
    <script src='{{ asset('assets/vendor/fullcalendar/timegrid/main.js')}}'></script>
    <script src='{{ asset('assets/vendor/fullcalendar/list/main.js')}}'></script>
    <script src='{{ asset('assets/vendor/fullcalendar/interaction/main.js')}}'></script>
    <script src='{{ asset('assets/js/plugins/calender.js')}}'></script>
    <script src="{{ asset('assets/js/select2.min.js')}}"></script>
    
</body>
</html>
