@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 215px;">
    <div class="container-fluid iq-container">
        <div class="row">
            <div class="col-md-12">
                <div class="flex-wrap d-flex justify-content-between align-items-center">
                    <div>
                       <h1 style="color: black">Listado de Ingredientes</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="conatiner-fluid content-inner mt-n5 py-0">
     @if(session('success'))
         <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
             <span>{{ session('success') }}</span>
             <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
     @endif
    <div class="row">
       <div class="col-sm-12">
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
@endsection