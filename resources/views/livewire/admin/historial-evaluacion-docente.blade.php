<div>
    <div class="iq-navbar-header" style="height: 80px;"></div>

    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
        <p class="text-black">Materias con Evaluacion Docente Habilitados</p>
        <div class="col-md-12 col-lg-12">
            <div class="row row-cols-1">
                <div class="overflow-hidden d-slider1 ">
                    @foreach ($materiasHabilitados as $item)
                    <div class="col-lg-2 col-md-12">
                        <a class="card" >
                            <div class="card-body">
                                <div class="d-grid mb-2">
                                    <div class="d-flex align-items-center text-black">
                                        <p class="mb-0 h6">{{ $item->materia->curso->nombre }}</p>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div> 
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                <h4 class="card-title">Datos de las respuestas</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
