<div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
               <div class="card-header">
                  <div class="header-title">
                     <h4 class="card-title">Información de la Materia</h4>
                  </div>
            </div>
               <div class="card-body">
                   <div class="form-group">
                      <ul class="list-group list-group-flush">
                         <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="fw-bold">Docente</div>
                            <span>{{ $curso->docente->persona->nombre }} {{$curso->docente->persona->ap_paterno}} {{$curso->docente->persona->ap_materno}}</span>
                         </li>
                         <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="fw-bold">Materia</div>
                            <span>{{ $curso->curso->nombre }}</span>
                         </li>
                         <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="fw-bold">Horario</div>
                            <span>{{ $curso->horario->turno }}</span>
                         </li>
                         <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="fw-bold">Aula</div>
                            <span>{{ $curso->aula->nombre }}</span>
                         </li>
                         <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="fw-bold">Fecha Inicio</div>
                            <span>{{ $curso->fecha_ini }}</span>
                         </li>
                         <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="fw-bold">Fecha Fin</div>
                            <span>{{ $curso->fecha_fin }}</span>
                         </li>
                      </ul>
                   </div>
               </div>
            </div>
        </div>
        <div class="col-lg-8">
         @if(session('success'))
            <div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
               <span>{{ session('success') }}</span>
               <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
         @endif
         <div class="card">
            <div class="card-header">
               <div class="header-title">
                  <h4 class="card-title">Planificar la materia</h4>
               </div>
               <form method="POST" action="{{ route('guardar.planificacion', [$curso->id]) }}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                     <label class="form-label"><span class="text-black">Foto</span> (Opcional)</label>
                     <input type="file" class="form-control" name="imagen">
                     @error('imagen') <span class="text-danger">{{ $message }}</span> @enderror
                 </div> 
                  <textarea name="planificacion" id="editorCurso" cols="30">{!! $curso->descripcion !!}</textarea>
                  <br>
                  @if ($curso->estado == 1)
                     <div class="text-center">
                        <button type="submit" class="btn btn-secondary">Guardar</button>
                     </div>
                  @endif
                  <br>
               </form>
            </div>
          </div>
            @livewire('docente.components.config-docs', ['id' => $curso->id])
        </div>
   </div>
</div>
@section('scripts')
   <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
   <script>
      ClassicEditor
            .create( document.querySelector( '#editorCurso' ) )
            .catch( error => {
                console.error( error );
            } );
   </script>
@endsection