@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 90px;"></div> 
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-lg-12">
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