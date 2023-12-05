<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="d-grid grid-flow-col align-items-center justify-content-between mb-2">
                <a class="btn btn-sm btn-ligth" href="{{ route('show.tarea', $tarea->id) }}">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M9 19h-4v-2h4v2zm2.946-4.036l3.107 3.105-4.112.931 1.005-4.036zm6.054-9.053l2-2.024v-.887h-4.609l2.609 2.808v.103zm0 
                                12.134v3.955h-16v-16.192l2.666-2.808h-4.666v21h20v-7.98l-2 2.025zm-14.297-11.045h12.651l-3.312-3.569v-.41c.001-1.668-1.352-3.021-3.021-3.021-1.667 0-3.021 
                                1.332-3.021 3l.001.431-3.298 3.569zm6.297-5c.553 0 1 .448 1 1s-.447 1-1 1-1-.448-1-1 .447-1 1-1zm14 7.125l-7.898 7.996-3.202-3.202 7.898-7.995 3.202 3.201z"/>
                            </svg> {{ $tarea->titulo }}
                        </p>
                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.5 5L15.5 12L8.5 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <p class="mb-0">{{ \Carbon\Carbon::parse($tarea->inico)->format('Y-m-d') }} a {{ \Carbon\Carbon::parse($tarea->fin)->format('Y-m-d') }}</p>
                    </div>
                    <p>{{ substr($tarea->descripcion, 0, 25) }}</p>
                </a>
                @if (auth()->user()->hasRole('Docente'))
                    <div class="dropdown">
                        <span class="h5" id="dropdownMenuButton15" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg class="icon-24" xmlns="http://www.w3.org/2000/svg" width="24"  viewBox="0 0 24 24" fill="none">
                                <g><g>
                                    <circle cx="7" cy="12" r="1" fill="black"/>
                                    <circle cx="12" cy="12" r="1" fill="black"/>
                                    <circle cx="17" cy="12" r="1" fill="black"/>
                                </g></g>
                            </svg>
                        </span>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton15" style="">
                            <a class="dropdown-item cursoMano" wire:click='editarTarea({{$tarea->id}})'>
                                <svg  width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-2 icon-20">
                                    <path d="M13.7476 20.4428H21.0002" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.78 3.79479C13.5557 2.86779 14.95 2.73186 15.8962 3.49173C15.9485 3.53296 17.6295 4.83879 17.6295 4.83879C18.669 5.46719 18.992 6.80311 18.3494 7.82259C18.3153 7.87718 8.81195 19.7645 8.81195 19.7645C8.49578 20.1589 8.01583 20.3918 7.50291 20.3973L3.86353 20.443L3.04353 16.9723C2.92866 16.4843 3.04353 15.9718 3.3597 15.5773L12.78 3.79479Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M11.021 6.00098L16.4732 10.1881" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>Editar
                            </a>
                            <a class="dropdown-item cursoMano" wire:click='eliminarTarea({{$tarea->id}})'>
                                <svg  width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-2 icon-20">
                                    <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>Borrar
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>