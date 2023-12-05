<div>
    <div class="iq-navbar-header" style="height: 80px;"></div> 
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-md-12">
                <div class="row row-cols-1">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="row no-gutters">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="text-center">
                                            <h4 class="card-title mb-0">EVALUACIÓN AL DOCENTE</h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <form class="form" action="#">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Escribe la pregunta">
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm">Cancelar</button>
                                                <button type="button" class="btn btn-primary btn-sm">Cancelar</button>
                                                <button type="button" class="btn btn-secondary btn-sm">Subir</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="text-center">
                                        <h4 class="card-title mb-0">PREGUNTAS DE EVALUACIÓN AL DOCENTE</h4>
                                    </div>
                                    <p>descripcion</p>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="text-center">MAL</th>
                                                <th class="text-center">REGULAR</th>
                                                <th class="text-center">BUENO</th>
                                                <th class="text-center">MUY BUENO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="white-space: pre-wrap;">¿Como de comoma, sabe n que paso ayer no estoy seguro pero paso algo que no crei que iba a pasar ya , desde hace mucho?</td>
                                                <td class="text-center">
                                                    <input type="radio" class="form-check-input">
                                                </td>
                                                <td class="text-center">
                                                    <input type="radio" class="form-check-input">
                                                </td>
                                                <td class="text-center">
                                                    <input type="radio" class="form-check-input">
                                                </td>
                                                <td class="text-center">
                                                    <input type="radio" class="form-check-input">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="text-center">
                                        <a wire:click='guardarAsistencia()' type="button" class="btn btn-primary">Guardar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
