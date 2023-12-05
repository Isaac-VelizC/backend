@extends('layouts.app')

@section('content')

<div class="iq-navbar-header" style="height: 90px;"></div> 

<div class="conatiner-fluid content-inner mt-n5 py-0">
   <div class="row">
      <div class="col-lg-6">
         <div class="row">
            <div class="col-md-6">
               @foreach ($cursos as $item)
                  <div class="card">
                     <a class="cursoMano" href="{{ route('cursos.curso', [$item->cursoDocente->id]) }}">
                        <div class="card-body">
                           <div class="d-flex justify-content-between">
                              <div>
                                 <span><b>{{$item->cursoDocente->curso->nombre}}</b></span>
                              </div>
                           </div>
                           <p>{{$item->cursoDocente->horario->turno}}</p>
                        </div>
                     </a>
                  </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
</div>
@endsection