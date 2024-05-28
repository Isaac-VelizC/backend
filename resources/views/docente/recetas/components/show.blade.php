<div >
    <h3>{{ $recipe->titulo }}</h3>
    <br>
    <div class="row">
        <p><strong>Tiempo:</strong> {{ $recipe->tiempo }} minutos</p>
        <p><strong>Porciones:</strong> {{ $recipe->porciones }}</p>
        <p><strong>Ingredientes:</strong></p>
    </div>
    <ul>
        @foreach (json_decode($recipe->ingredientes) as $ingrediente)
            <li>{{ $ingrediente }}</li>
        @endforeach
    </ul>
    <p><strong>Pasos:</strong></p>
    <ol>
        @foreach (json_decode($recipe->pasos) as $paso)
            <li>{{ $paso }}</li>
        @endforeach
    </ol>
</div>
