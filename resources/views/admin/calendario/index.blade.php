@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 80px;"></div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div id="myAlert"></div>
    <div class="row">
        <div class="col-sm-12 col-lg-3">
            @livewire('admin.calendario')
        </div>
        <div class="col-sm-12 col-lg-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Gestionar el Calendario</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div id="calendar1" class="calendar-s"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="date-event" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Crear Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate id="formEventos">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div id="alertas"></div>
                    <div class="row">
                        <input type="hidden" id="id" name="id">
                        <div class="form-group col-md-12">
                            <label class="form-label">Calegoria</label>
                            <select class="form-select form-select-sm mb-3 shadow-none" name="tipo_id" required>
                                <option value="" selected>Seleccionar</option>
                                @foreach ($categorias as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="form-label" for="title">Titulo</label>
                            <input type="text" class="form-control form-select-sm" id="title" name="title" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="form-label" for="descripcion">Descripcion</label>
                            <textarea type="text" class="form-control" id="descripcion" name="descripcion"></textarea>
                        </div>
                        <input type="hidden" id="schedule-start-date" name="start" aria-describedby="helpId" required>
                        <div class="form-group col-md-12">
                            <label for="schedule-end-date">Fin</label>
                            <input type="date" class="form-control" id="schedule-end-date" name="end" aria-describedby="helpId" required min="{{ now()->format('Y-m-d') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-warning"id="btnModificar">Modificar</button>
                    <button type="button" class="btn btn-danger" id="btnEliminar">Eliminar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection