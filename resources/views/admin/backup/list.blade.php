@extends('layouts.app')

@section('content')
<div class="position-relative iq-banner">
    <div class="iq-navbar-header" style="height: 150px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center text-black">
                        <div>
                            <h4>{{ Breadcrumbs::render('Admin.Backup') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="iq-header-img">
            <img src="{{ asset('img/fondo1.jpg') }}" alt="header" class="img-fluid w-100 h-100 animated-scaleX">
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
    @if(session('error'))
    <div id="myAlert" class="alert alert-left alert-danger alert-dismissible fade show mb-3 alert-fade" role="alert">
        <span>{{ session('error') }}</span>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <h4>Archivos de Backup</h4>
                        <form action="{{ route('backup.run') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary mb-3">Ejecutar Backup</button>
                        </form>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table id="datatableUsers" class="table table-striped" data-toggle="data-table">
                            <thead>
                                <tr>
                                    <th>Archivo</th>
                                    <th>Tamaño</th>
                                    <th>Última modificación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($backups as $backup)
                                <tr>
                                    <td>{{ basename($backup['path']) }}</td>
                                    <td>{{ number_format($backup['size'] / 1048576, 2) }} MB</td>
                                    <td>{{ date('Y-m-d H:i:s', $backup['last_modified']) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('backup.download', basename($backup['path'])) }}" class="btn btn-sm btn-icon btn-success">
                                            <i class="bi bi-download"></i>
                                        </a>
                                    </td>
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