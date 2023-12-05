@extends('layouts.app')

@section('content')

<div class="iq-navbar-header" style="height: 80px;"></div>

<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <p class="mb-md-0 mb-2 d-flex align-items-center">RECETAS</p>
                        <div class="d-flex align-items-center flex-wrap">
                            Nueva Receta
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <p>Tipo de receta</p>
                                    <div class="form-check">
                                        <input type="radio" name="radios" class="form-check-input" id="disabledRadio1">
                                        <label class="form-check-label" for="disabledRadio1">Platos</label>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="radio" name="radios" class="form-check-input" id="disabledRadio2">
                                        <label class="form-check-label" for="disabledRadio2">Postres</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="disabledSelect" class="form-label">Ingredientes</label>
                                    <select id="disabledSelect" class="form-select">
                                        <option>Disabled select</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Procesar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection