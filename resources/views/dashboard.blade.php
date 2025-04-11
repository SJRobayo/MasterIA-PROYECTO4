<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('INSTACART') }}
        </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Navbar -->
        <nav class="bg-white shadow-md rounded-lg p-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">INSTACART</h1>
            <ul class="flex space-x-6">
                <li><a href="#" class="text-gray-600 hover:text-gray-800">Inicio</a></li>
                <li><a href="#" class="text-gray-600 hover:text-gray-800">Productos</a></li>
                <li><a href="#" class="text-gray-600 hover:text-gray-800">Recomendaciones</a></li>
                <li><a href="resources\views\contacto.blade.php" class="text-gray-600 hover:text-gray-800">Contacto</a></li>
            </ul>
        </nav>

        <!-- Sección de Productos -->
        <div class="mt-8">
            <form action="{{ route('buscar') }}" method="GET">
                <input type="text" name="q" placeholder="¿Qué estás buscando?" class="border p-2 rounded">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Buscar</button>
            </form>

            <h2 class="text-2xl font-bold text-gray-800 mb-4">Nuestros Productos</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Producto 1 -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($productos as $producto)
                        <div class="bg-white shadow-md rounded-lg p-4">
                            <img src="https://via.placeholder.com/300" alt="Producto {{ $producto['id'] }}" class="w-full h-40 object-cover rounded-md">
                            <h3 class="text-lg font-bold mt-2">{{ $producto['nombre'] }}</h3>
                            <p class="text-gray-600 text-sm">Aisle_id: {{ $producto['aisle_id'] }} | Department_id: {{ $producto['department_id'] }}</p>
                            <p class="text-green-600 font-bold mt-2">ID: {{ $producto['id'] }}</p>
                            <button class="mt-3 w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Comprar</button>
                        </div>
                    @endforeach
                </div>

                <!-- Producto 2
                <div class="bg-white shadow-md rounded-lg p-4">
                    <img src="https://via.placeholder.com/300" alt="Producto 2" class="w-full h-40 object-cover rounded-md">
                    <h3 class="text-lg font-bold mt-2">All-Seasons Salt</h3>
                    <p class="text-gray-600 text-sm">Aisle_id: 104 | Department_id: 13</p>
                    <p class="text-green-600 font-bold mt-2">ID: 2</p>
                    <button class="mt-3 w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Comprar</button>
                </div> -->

                <!-- Producto 3 -->
                <!-- <div class="bg-white shadow-md rounded-lg p-4">
                    <img src="https://via.placeholder.com/300" alt="Producto 3" class="w-full h-40 object-cover rounded-md">
                    <h3 class="text-lg font-bold mt-2">Robust Golden Unsweetened Oolong Tea</h3>
                    <p class="text-gray-600 text-sm">Aisle_id: 94 | Department_id: 7</p>
                    <p class="text-green-600 font-bold mt-2">ID: 3</p>
                    <button class="mt-3 w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Comprar</button>
                </div> -->
            </div>
        </div>
    </div>
</div>

</x-app-layout>
