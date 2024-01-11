@extends('layouts.app')

@section('content')
    <div class="iq-navbar-header" style="height: 90px;"></div> 
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header pb-3">
                        <h3 class="block-title text-center">CALIFICACIONES</h3>
                      </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="my-table" class="table mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center prc-wrap">Materia</th>
                                        <th class="text-center prc-wrap">Nota</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cursos as $item)
                                        <tr>
                                            <th scope="row"><a href="#">{{ $item['nombre'] }}</a></th>
                                            <td class="text-center child-cell">{{ $item['nota'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection