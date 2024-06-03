<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ 'Instituto Técnico Igla' }}</title>
    <!-- Agrega los enlaces para los íconos -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img/icon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/hope-ui.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css')}}"/>
    <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/core/main.css')}}' />
    <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/daygrid/main.css')}}' />
    <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/timegrid/main.css')}}' />
    <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/list/main.css')}}' />
    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/aos/dist/aos.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/hope-ui.min.css?v=2.0.0')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.min.css?v=2.0.0')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/dark.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/rtl.min.css')}}"/>
    
    <script>
        var baseUrl = {!! json_encode(url('/')) !!}
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @livewireStyles
</head>
<body>
      <!-- loader END -->
    @if (auth()->check())
        @if (in_array('Estudiante', Auth::user()->getRoleNames()->toArray()))
            @include('layouts.navbar.sidebar.estud')
        @elseif (in_array('Docente', Auth::user()->getRoleNames()->toArray()))
            @include('layouts.navbar.sidebar.docente')
        @else
            @include('layouts.navbar.sidebar.admin')
        @endif
        <main class="main-content">
            @include('layouts.navbar.nav')
            @yield('content')
            @role('Admin')
                <div class="btn-download">
                    <a class="btn btn-danger px-3 py-2" href="{{ route('backup.list') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M15.836 7.353c-.793-.828-1.931-1.44-3.27-1.628l.211-1.492-3.097 2.02 2.465 2.57.202-1.486c.86.15 1.515.509 
                            1.96.972 1.035 1.081.919 2.73-.453 3.625-1.299.847-3.182.664-4.216-.415-.727-.758-.938-1.852-.183-2.846l-1.297-1.352c-1.605 
                            1.571-1.521 3.731-.096 5.22 1.746 1.82 4.912 2.088 7.043.698 2.18-1.421 2.514-4.027.731-5.886zm4.164 11.147c0 
                            .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm4-2.5l-5-14h-14l-5 14v6h24v-6zm-17.666-12h11.333l3.75 11h-18.834l3.751-11zm15.666 16h-20v-3h20v3z"/>
                        </svg>
                    </a>
                </div>
            @endrole
            @include('layouts.footer.footer')
        </main>
    @else
        @yield('content')
        @include('layouts.footer.footer')
    @endif
    
    @livewireScripts
    @yield('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v1.x.x/dist/livewire-sortable.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script src='{{ asset('assets/js/plugins/exports.js')}}'></script>
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
    <script src="{{ asset('/assets/js/plugins/setting.js')}}"></script>
    <script src="{{ asset('/assets/js/plugins/fslightbox.js')}}"></script>
    <script src="{{ asset('/assets/js/plugins/form-wizard.js')}}"></script>
    <script src="{{ asset('/assets/vendor/aos/dist/aos.js')}}"></script>
    
    <script>
        function mostrarBarraProgreso() {
            document.getElementById('barraProgreso').style.display = 'block';
            let progreso = 0;
            const intervalo = setInterval(function() {
                document.getElementById('barraProgresoInterior').style.width = progreso + '%';
                document.getElementById('barraProgresoInterior').innerHTML = progreso + '%';
                progreso++;
                if (progreso > 100) {
                    clearInterval(intervalo);
                    document.getElementById('barraProgreso').style.display = 'none';
                }
            }, 50); // Puedes ajustar el intervalo según tus necesidades
        }
    </script>
    
</body>
</html>
