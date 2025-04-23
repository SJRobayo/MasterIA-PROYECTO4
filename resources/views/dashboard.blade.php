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
                <form action="{{ route('buscar') }}" method="GET">
                    <input type="text" name="q" placeholder="Search" class="border p-2 rounded">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Buscar</button>
                </form>
                <ul class="flex space-x-6">
                    <li><a href="#" class="text-gray-600 hover:text-gray-800">Inicio</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-gray-800">Productos</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-gray-800">Recomendaciones</a></li>
                    <li><a href="resources\views\contacto.blade.php"
                            class="text-gray-600 hover:text-gray-800">Contacto</a></li>
                </ul>
            </nav>

            <!-- Sección de Productos -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Based on your recent buys</h2>

                <div class="swiper mySwiper select-none">
                    <div class="swiper-wrapper">
                        @foreach (range(1, 3) as $repeat)
                            {{-- repite 3 veces los mismos productos --}}
                            @foreach ($recommendations as $producto)
                                <div
                                    class="swiper-slide bg-white shadow-md rounded-lg p-4 w-72 h-48 flex flex-col justify-between">
                                    <h3 class="text-base font-bold mb-1">{{ $producto->product_name }}</h3>
                                    <p class="text-gray-600 text-sm mb-1">
                                        # {{ $producto->aisle->aisle }} | Dept: {{ $producto->department->department }}
                                    </p>
                                    <p class="text-green-600 font-semibold text-sm mb-2">ID: {{ $producto->id }}</p>
                                    <button
                                        class="w-full bg-blue-500 text-white text-sm py-1 rounded hover:bg-blue-600">
                                        Comprar
                                    </button>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>

            </div>


            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Most popular</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Producto 1 -->
                    @foreach ($populars as $popular)
                        <div class="bg-white shadow-md rounded-lg p-4">
                            <h3 class="text-base font-bold mb-1">{{ $popular->product_name }}</h3>
                            <p class="text-gray-600 text-sm mb-1">
                                # {{ $popular->aisle->aisle }} | Dept: {{ $popular->department->department }}
                            </p>
                            <p class="text-green-600 font-semibold text-sm mb-2">ID: {{ $popular->id }}</p>
                            <button class="w-full bg-blue-500 text-white text-sm py-1 rounded hover:bg-blue-600">
                                Comprar
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        const swiper = new Swiper('.mySwiper', {
            slidesPerView: 'auto',
            spaceBetween: 20,
            loop: true,
            speed: 3000,
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
            },
            freeMode: true,
            freeModeMomentum: false,
            grabCursor: true
        });
    </script>



</x-app-layout>
