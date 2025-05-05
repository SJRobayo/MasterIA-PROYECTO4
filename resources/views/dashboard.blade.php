<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">RECOMENDATIONS</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 🔍 Resultados de búsqueda si existen --}}
            @if(isset($query))
                <div class="mb-12">

                    {{-- Recomendados que coinciden con la búsqueda --}}
                    @if($resultadosRecomendados->isNotEmpty())
                        <h2 class="text-2xl font-bold text-indigo-700 mb-4">
                            🔮 Recomended products related with "{{ $query }}"
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                            @foreach($resultadosRecomendados as $producto)
                                <div class="bg-white shadow-md rounded-lg p-4 border-l-4 border-indigo-500">
                                    <h3 class="text-base font-bold mb-1">{{ $producto->product_name }}</h3>
                                    <p class="text-gray-600 text-sm mb-1">
                                        Aisle: {{ $producto->aisle->aisle }} | Dept: {{ $producto->department->department }}
                                    </p>
                                    <p class="text-green-600 font-semibold text-sm mb-2">ID: {{ $producto->id }}</p>
                                    <button class="w-full bg-indigo-500 text-white text-sm py-1 rounded hover:bg-indigo-600">
                                        Buy
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Todos los productos que coinciden con la búsqueda --}}
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">
                        📦 All results for "{{ $query }}"
                    </h2>
                    @if($resultados->isEmpty())
                        <p class="text-gray-600">⚠️ No products found.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($resultados as $producto)
                                <div class="bg-white shadow-md rounded-lg p-4">
                                    <h3 class="text-base font-bold mb-1">{{ $producto->product_name }}</h3>
                                    <p class="text-gray-600 text-sm mb-1">
                                        Aisle: {{ $producto->aisle->aisle }} | Dept: {{ $producto->department->department }}
                                    </p>
                                    <p class="text-green-600 font-semibold text-sm mb-2">ID: {{ $producto->id }}</p>
                                    <button class="w-full bg-blue-500 text-white text-sm py-1 rounded hover:bg-blue-600">
                                        Buy
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Sugerencias relacionadas --}}
                    @if(!empty($sugerencias))
                        <div class="mt-10">
                            <h3 class="text-xl font-semibold mb-2">🔁 You can be interested on</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($sugerencias as $sugerido)
                                    <div class="bg-white shadow-md rounded-lg p-4">
                                        <h4 class="text-base font-bold mb-1">{{ $sugerido->product_name }}</h4>
                                        <p class="text-gray-600 text-sm mb-1">
                                            Aisle: {{ $sugerido->aisle->aisle_name }} | Dept: {{ $sugerido->department->department_name }}
                                        </p>
                                        <p class="text-green-600 font-semibold text-sm mb-2">ID: {{ $sugerido->id }}</p>
                                        <button class="w-full bg-blue-500 text-white text-sm py-1 rounded hover:bg-blue-600">
                                            Buy
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            @endif


            <!-- Sección de Recomendaciones -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Based on your recent buys</h2>
                <div class="swiper mySwiper select-none">
                    <div class="swiper-wrapper">
                        @foreach (range(1, 3) as $repeat)
                            @foreach ($recommendations as $producto)
                                <div class="swiper-slide bg-white shadow-md rounded-lg p-4 w-72 h-48 flex flex-col justify-between">
                                    <h3 class="text-base font-bold mb-1">{{ $producto->product_name }}</h3>
                                    <p class="text-gray-600 text-sm mb-1">
                                        Aisle: {{ $producto->aisle->aisle }} | Dept: {{ $producto->department->department }}
                                    </p>
                                    <p class="text-green-600 font-semibold text-sm mb-2">ID: {{ $producto->id }}</p>
                                    <button class="w-full bg-blue-500 text-white text-sm py-1 rounded hover:bg-blue-600">
                                        Buy
                                    </button>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sección de Productos Populares -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Most popular</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($populars as $popular)
                        <div class="bg-white shadow-md rounded-lg p-4">
                            <h3 class="text-base font-bold mb-1">{{ $popular->product_name }}</h3>
                            <p class="text-gray-600 text-sm mb-1">
                                Aisle: {{ $popular->aisle->aisle }} | Dept: {{ $popular->department->department }}
                            </p>
                            <p class="text-green-600 font-semibold text-sm mb-2">ID: {{ $popular->id }}</p>
                            <button class="w-full bg-blue-500 text-white text-sm py-1 rounded hover:bg-blue-600">
                                Buy
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- SwiperJS -->
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
