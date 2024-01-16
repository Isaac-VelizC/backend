"use strict"

if (document.querySelectorAll('#calendar1').length) {
  document.addEventListener('DOMContentLoaded', function () {
    const btnGuardar = document.getElementById("btnGuardar");
    const btnEliminar = document.getElementById("btnEliminar");
    const btnModificar = document.getElementById("btnModificar");
    let formulario = document.querySelector("#formEventos");
    let calendarEl = document.getElementById('calendar1');
    let calendar1 = new FullCalendar.Calendar(calendarEl, {
      plugins: ["timeGrid", "dayGrid", "list", "interaction"],
      timeZone: "UTC",
      defaultView: "dayGridMonth",
      locale: 'es',
      displayEventTime:false,
      contentHeight: "auto",
      eventLimit: true,
      droppable: true,
      dayMaxEvents: 4,
      eventOverlap: false,
      header: {
          left: "prev,next today",
          center: "title",
          right: "dayGridMonth,listYear"
      },
      
      events: baseUrl+"/calendar/mostrar",
      
      dateClick:function (info) {
        formulario.reset();
        $('#schedule-start-date').val(info.dateStr)
        $('#schedule-end-date').val(info.dateStr)
        btnEliminar.style.display = 'none';
        btnModificar.style.display = 'none';
        btnGuardar.style.display = 'block';
        $('#date-event').modal('show')
      },

      eventClick:function (info) {
        axios.post(baseUrl+"/calendar/"+info.event.id+"/evento/edit")
            .then((respuesta) => {
                formulario.id.value = respuesta.data.id;
                formulario.tipo_id.value = respuesta.data.tipo_id;
                formulario.title.value = respuesta.data.title;
                formulario.descripcion.value = respuesta.data.descripcion;
                formulario.start.value = respuesta.data.start;
                formulario.end.value = respuesta.data.end;
                btnEliminar.style.display = 'block';
                btnModificar.style.display = 'block';
                btnGuardar.style.display = 'none';
                $("#date-event").modal("show");
                calendar1.refetchEvents();
            })
            .catch(error => {
                const myAlert = $("#alertas");
                if (error.response && error.response.status === 422 && error.response.data.errors) {
                    const errores = error.response.data.errors;
                    Object.keys(errores).forEach((campo) => {
                        const mensajeError = errores[campo][0];
                        const campoInput = $(`#${campo}`);
                        campoInput.addClass("is-invalid");
                        campoInput.next('.invalid-feedback').html(mensajeError);
                    });
                } else if (error.response && error.response.data && error.response.data.error) {
                    myAlert.html('<div class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">' +
                        '<span>' + error.response.data.error + '</span>' +
                        '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>');
                }
            });
      }
  });
  calendar1.render();
    btnGuardar.addEventListener("click", function(event) {
        enviarDatos("/calendar/store", event);
    });
    btnEliminar.addEventListener("click", function(event) {
        enviarDatos("/calendar/"+ formulario.id.value +"/evento/delete", event);
    });
    btnModificar.addEventListener("click", function(event) {
        enviarDatos("/calendar/"+ formulario.id.value +"/evento/update", event);
    });

    function enviarDatos(url, event) {
        event.preventDefault();
        const datos = new FormData(formulario);
        const newUrl = baseUrl + url;
        axios.post(newUrl, datos)
            .then((respuesta) => {
                calendar1.refetchEvents();
                if (respuesta.data && respuesta.data.message) {
                    $("#myAlert").html('<div class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">' +
                    '<span>' + respuesta.data.message + '</span>' +
                    '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>');
                }
                $("#date-event").modal("hide");
            })
            .catch(error => {
                const myAlert = $("#alertas");
                if (error.response && error.response.status === 422 && error.response.data.errors) {
                    const errores = error.response.data.errors;
                    Object.keys(errores).forEach((campo) => {
                        const mensajeError = errores[campo][0];
                        const campoInput = $(`#${campo}`);
                        campoInput.addClass("is-invalid");
                        campoInput.next('.invalid-feedback').html(mensajeError);
                    });
                } else if (error.response && error.response.data && error.response.data.error) {
                    myAlert.html('<div class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">' +
                        '<span>' + error.response.data.error + '</span>' +
                        '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>');
                }
            });
    }
  });
  
}