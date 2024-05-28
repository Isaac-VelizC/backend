@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 90px;"></div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-lg-6">
            @if (count($cursos) > 0 )
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Materias</h4>
                    </div>
                </div>
            @endif
            <br>
            <div class="row">
                @foreach ($cursos as $item)
                <div class="col-md-12">
                    <div class="row row-cols-1 row-cols-md-2 mb-3 text-center">
                        <div class="col">
                            <div class="card rounded-3 " style="background: {{ $item->cursoDocente->curso->color }}">
                                <div class="card-body">
                                    <h4 class="my-0 fw-normal">{{ $item->cursoDocente->curso->nombre }}</h4>
                                    <br>
                                    <a type="button" href="{{ route('cursos.curso', $item->cursoDocente->id) }}" class="btn btn-outline-primary">Entrar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Trabajos pendientes</h4>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if (count($tareasPendientes) <= 0)
                        <div class="text-center py-3">Aqui saldran tus trabajos pendientes</div>
                    @else
                    @foreach ($tareasPendientes as $item)
                        <div class="card-body">
                            <h5 class="card-title"><a href="{{ route('show.tarea', $item->id) }}">{{ $item->titulo }}</a></h5>
                            <div class="text-muted">Se acepta hasta la fecha {{ $item->fin }}</div>
                        </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div id="calendar3" class="calendar-s"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    "use strict";
    if (document.querySelectorAll('#calendar3').length) {
        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar3');
            let calendar3 = new FullCalendar.Calendar(calendarEl, {
                selectable: true,
                plugins: ["timeGrid", "dayGrid", "list", "interaction"],
                timeZone: "UTC",
                defaultView: "dayGridMonth",
                locale: 'es',
                displayEventTime: false,
                contentHeight: "auto",
                eventLimit: true,
                droppable: true,
                dayMaxEvents: 4,
                header: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth"
                },
                displayEventTime: {
                    hour: 'numeric',
                    minute: '2-digit',
                    separator: ' - ',
                    meridiem: false,
                    omitZeroMinute: false,
                },
                events: baseUrl + "/calendar/mostrar/trabajos",

                eventClick: function (info) {
                    let eventId = info.event.id;
                    window.location.href = '/posts-tareas/' + eventId;
                },
            });

            calendar3.render();
        });
    }
</script>
@endsection