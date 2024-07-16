<!-- MODAL PARA BUSCAR LOS INGREDIENTES Y SELECCIONAR PARA EL REGISTRO DE LAS RECETAS -->
<div class="modal fade" id="selectIngrediente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
       <div class="modal-content">
            <div class="modal-body">
                <div class="col-sm-12 col-lg-12">
                    <div class="row">
                        <div class="card-body">
                            <input type="search" class="form-control" id="nombre" placeholder="Escribe Ingredientes">
                            <hr>
                            <div id="resultados"></div>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </div>
 </div>
 @section('scripts')
 <script>
    const nombreInput = document.getElementById('nombre');
    const resultadosDiv = document.getElementById('resultados');
    nombreInput.addEventListener('input', function () {
        const nombre = nombreInput.value;
        axios.post('{{ route('admin.buscar-ingredientes') }}', {
            nombre: nombre
        })
        .then(response => {
            const resultados = response.data.data || response.data.resultados || response.data;
            mostrarResultados(resultados);
        })
        .catch(error => {
            console.error(error);
        });
    });

    function mostrarResultados(resultados) {
        resultadosDiv.innerHTML = '';
        if (Array.isArray(resultados) && resultados.length > 0) {
            resultados.forEach(ingrediente => {
                resultadosDiv.innerHTML += `
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action"  data-bs-dismiss="modal" onclick="limpiarBuscador()" wire:click="seleccionarIngrediente(${ingrediente.id})"> <img src='{{ asset('img/ingred.png') }}'width='15px' heigth='15px'> ${ingrediente.nombre}</a>
                </div>`;
            });
        } else {
            resultadosDiv.innerHTML = "<div class='text-center'><p>No se encontraron resultados</p></div>";
        }
    }

    function limpiarBuscador() {
        nombreInput.value = '';
    }
</script>
@endsection
