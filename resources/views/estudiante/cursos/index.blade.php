@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 80px;"></div> 
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="row row-cols-1">
                <div class="overflow-hidden d-slider1">
                    <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                        @foreach ($events as $item)
                        <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700" style="border-bottom: solid 4px {{ $item['color'] }}">
                            <a class="card-body" href="{{ route('cursos.curso', [$item['id']]) }}">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span><b>{{ $item['nombre'] }}</b></span>
                                    </div>
                                    @if ($item['count'] > 0)
                                    <div>
                                        <span class="badge bg-danger">{{ $item['count'] }}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div>
                                        <span>{{ $item['turno'] }}</span>
                                    </div>
                                    <div>
                                        <span>Nota <b>{{ $item['nota'] }}</b></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="swiper-button swiper-button-next"></div>
                    <div class="swiper-button swiper-button-prev"></div>
                </div>
            </div>
        </div> 
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header pb-3">
                            <h5 class="block-title text-center">CARRERA DE GASTRONOMIA</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive pricing pt-2">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            @foreach ($cursosPorSemestres->pluck('nombre_semestre')->unique() as $semestre)
                                                <th>{{ $semestre }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ($cursosPorSemestres->pluck('nombre_semestre')->unique() as $semestre)
                                                <td>
                                                    @foreach ($cursosPorSemestres->where('nombre_semestre', $semestre) as $curso)
                                                      <div class="card-body"  style="border-bottom: 4px solid {{ $curso->color }}; border-bottom-left-radius: 5%; border-bottom-right-radius: 5%;">
                                                         <div class="d-flex justify-content-between">
                                                               <span><b>{{ $curso->nombre }}</b></span>
                                                         </div>
                                                         @if ($cursosProgramados->contains('materia_id', $curso->id))
                                                            @php
                                                               $cursoProgramado = $cursosProgramados->where('materia_id', $curso->id)->first();
                                                               if ($cursoProgramado) {
                                                                     $nota = optional($cursoProgramado->calificaciones->where('estudiante_id', auth()->user()->persona->estudiante->id)->first())->calificacion ?: null;
                                                               }
                                                            @endphp
                                                            @if ($cursoProgramado)
                                                                <a href="{{ route('cursos.curso', $cursoProgramado->id) }}">
                                                                    <div class="d-flex justify-content-between mt-2">
                                                                        <span>{{ $cursoProgramado->horario->turno }}</span>
                                                                        <b>{{ $nota ? $nota : 'Esperando' }}</b>
                                                                    </div>
                                                                </a>
                                                            @endif
                                                         @endif
                                                      </div>
                                                      <hr>
                                                    @endforeach
                                                </td>
                                            @endforeach
                                        </tr>
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
