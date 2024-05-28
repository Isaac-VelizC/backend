@extends('layouts.app')

@section('content')
<div class="iq-navbar-header" style="height: 80px;"></div>
<div class="container-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                @if(session('success'))
                <div id="myAlert" class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if(session('error'))
                <div id="myAlert" class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    <span>{{ session('error') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="col-md-12 col-lg-12">
                    <div class="overflow-hidden card aos-init aos-animate" data-aos="fade-up" data-aos-delay="600">
                        <div class="card-header">
                            <div class="header-title">
                                <h4 class="mb-2 card-title">Recetas guardadas generadas por IA</h4>
                                <p class="mb-0">
                                    Total: {{ count($lista) }}
                                    <svg class="me-2 text-primary icon-24" width="24" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z"></path>
                                    </svg>
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 table-responsive">
                            <table id="basic-table" class="table mb-0 table-striped" role="grid">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Tiempo</th>
                                        <th>Porciones</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($lista && count($lista) > 0)
                                        @foreach ($lista as $item)
                                            <tr>
                                                <td><strong>{{ $item->titulo }}</strong></td>
                                                <td>{{ $item->tiempo }} minutos</td>
                                                <td>{{ $item->porciones }}</td>
                                                <td class="text-center">
                                                    <a class="btn btn-sm btn-icon btn-success me-2" data-bs-toggle="modal" data-bs-placement="top" 
                                                        data-recipe-id="{{ $item->id }}" data-bs-target="#showRecipeModal">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">No hay recetas guardadas</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showRecipeModal" tabindex="-1" aria-labelledby="showRecipeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="recipe-details"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const showRecipeButtons = document.querySelectorAll('[data-bs-target="#showRecipeModal"]');
        const showRecipeModal = new bootstrap.Modal(document.getElementById('showRecipeModal'));
        showRecipeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const recipeId = this.getAttribute('data-recipe-id');
                axios.get(`/show/recipe/${recipeId}`)
                    .then(response => {
                        document.getElementById('recipe-details').innerHTML = response.data;
                        showRecipeModal.show();
                    })
                    .catch(error => console.error('Error al cargar la receta:', error));
            });
        });
        document.querySelector('.btn-close').addEventListener('click', function() {
            showRecipeModal.hide();
        });
        showRecipeModal._element.addEventListener('hidden.bs.modal', function () {
            document.body.classList.remove('modal-open');
            const modalBackdrop = document.querySelector('.modal-backdrop');
            if (modalBackdrop) {
                modalBackdrop.parentNode.removeChild(modalBackdrop);
            }
        });
    });
</script>
@endsection
