function cancelar() {
    // Lógica para cancelar
    console.log("Cancelar");
}

function guardar() {
    // Lógica para guardar
    console.log("Guardar");

}

function enviarDatos() {
    var formulario = document.getElementById('tareaForm1');
    var formulario2 = document.getElementById('tareaForm2');
    var formulario3 = document.getElementById('tareaForm3');
    var formData = new FormData(formulario);
    var formData2 = new FormData(formulario2);
    var url = baseUrl + "/guardar-tarea";
    var tareaId = formData.get('tarea_id');
    var requestUrl = tareaId ? baseUrl + "/actualizar-tarea/" + tareaId : url;
    axios.post(requestUrl, formData)
        .then(function(response) {
            console.log(response.data.mensaje);
            if (tareaId) {
                axios.post(requestUrl, formData2)
                .then(function(response) {
                    console.log(response.data.mensaje);
                })
                .catch(function(error) {
                    console.error(error);
                });
                formulario.reset();
                formulario2.reset();
                formulario3.reset();
            } else {                
                var nuevoIdTarea = response.data.id_tarea;
                document.getElementById('tarea_id_form1').value = nuevoIdTarea;
                document.getElementById('tarea_id_form2').value = nuevoIdTarea;
                document.getElementById('tarea_id_form3').value = nuevoIdTarea;
            }
        })
        .catch(function(error) {
            console.error(error);
            // Manejar errores si es necesario
        });
}

var camposFormulario = document.querySelectorAll('#tareaForm1 input, #tareaForm1 textarea');
camposFormulario.forEach(function (campo) {
    campo.addEventListener('blur', function() {
        enviarDatos();
    });
});

document.getElementById('botonGuardar').addEventListener('click', function() {
    enviarDatos();
});

