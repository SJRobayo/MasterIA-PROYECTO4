<h2 class="text-xl font-bold mb-4">Resultados para: "{{ $query }}"</h2>

@if(count($resultados))
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($resultados as $producto)
            <div class="bg-white shadow-md rounded-lg p-4">
                <img src="https://via.placeholder.com/300" alt="{{ $producto['nombre'] }}" class="w-full h-40 object-cover rounded-md">
                <h3 class="text-lg font-bold mt-2">{{ $producto['nombre'] }}</h3>
                <p class="text-gray-600 text-sm">Aisle_id: {{ $producto['aisle_id'] }} | Department_id: {{ $producto['department_id'] }}</p>
                <p class="text-green-600 font-bold mt-2">ID: {{ $producto['id'] }}</p>
                <button class="mt-3 w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Comprar</button>
            </div>
        @endforeach
    </div>
@else
    <p class="text-red-500">No se encontraron productos.</p>
@endif

@if(count($sugerencias))
    <h2 class="text-xl font-bold mt-8 mb-4">También te podría interesar:</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($sugerencias as $sugerencia)
            <div class="bg-gray-100 shadow-md rounded-lg p-4">
                <h3 class="text-md font-semibold">{{ $sugerencia['nombre'] }}</h3>
                <p class="text-sm text-gray-700">ID: {{ $sugerencia['id'] }}</p>
            </div>
        @endforeach
    </div>
@endif
