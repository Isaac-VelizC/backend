<div class="modal fade" id="cursoModal" tabindex="-1" aria-labelledby="cursoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cursoModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="cursoModalBody">
            </div>
        </div>
    </div>
</div>

    <script>
        function loadCursoData(cursoId, estudId) {
            var estudiante = estudId;
            axios.get(baseUrl + `/cursos/${cursoId}`)
                .then(response => {
                    const curso = response.data.curso;
                    const habilitados = response.data.events;
                    document.getElementById('cursoModalLabel').innerText = curso.nombre;
                    let eventsHtml = '<div class="row">';
                    habilitados.forEach(event => {
                        eventsHtml += `
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <b>Docente: ${event.docente}</b>
                                                <p>Turno: ${event.turno}</p>
                                                <p>Aula: ${event.aula}</p>
                                            </div>
                                            <div>
                                                <p class="h4"><a href="#" class="programar-link" data-id="${event.id}"><span class="badge bg-primary">Programar</span></a></p>
                                                <div><span>Cupos: 0 / ${event.cupo}</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    eventsHtml += '</div>';
                    document.getElementById('cursoModalBody').innerHTML = `
                        <div class="row">
                            <p>${curso.descripcion}</p>
                        </div>
                        <hr>
                        ${eventsHtml}
                    `;

                    // Agregar el evento de clic a los enlaces generados
                    document.querySelectorAll('.programar-link').forEach(link => {
                        link.addEventListener('click', function (event) {
                            event.preventDefault();
                            const eventId = this.getAttribute('data-id');
                            const programadoUrl = `${baseUrl}/curso/programdo/yoy/${eventId}/`+estudiante;
                            console.log(programadoUrl);
                            // Realiza la redirección o cualquier otra acción que desees
                            window.location.href = programadoUrl;
                        });
                    });
                })
                .catch(error => {
                    console.error('Error al cargar los datos del curso', error);
                });
        }
    </script>
