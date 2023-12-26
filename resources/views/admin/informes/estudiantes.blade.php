@extends('layouts.app')

@section('content')

<div class="iq-navbar-header" style="height: 170px;">
    <div class="container-fluid iq-container">
        <div class="row">
            <div class="col-md-12">
                <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                    <div>
                        <h1>Reporte de Estudiantes</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
                                        <h4 class="card-title mb-0">REPORTES DE ESTUDIANTES</h4>
                                    </div>
                                </div>
                                <hr>
                                <form class="form" action="#">
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="First name">
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Last name">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="text-center">
                                            <button type="button" class="btn btn-primary btn-sm">Cancelar</button>
                                            <button type="button" class="btn btn-secondary btn-sm">Buscar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                               <table id="datatable" class="table table-striped" data-toggle="data-table">
                                  <thead>
                                     <tr>
                                        <th>Nombre</th>
                                        <th>Docente</th>
                                        <th>Aula</th>
                                        <th>Modalidad</th>
                                        <th>Horario</th>
                                        <th>Estado</th>
                                        <th>Tags</th>
                                     </tr>
                                  </thead>
                                  <tbody>
                                   
                                  </tbody>
                               </table>
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection