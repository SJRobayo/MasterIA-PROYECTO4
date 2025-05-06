<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">RECOMENDATIONS</h2>
    </x-slot>

    <div class="py-12">
        @if (session('success'))
            <div class="bg-green-500 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 🔍 Resultados de búsqueda si existen --}}
            @if (isset($query))
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Resultados para "{{ $query }}"</h2>

                    @if ($resultados->isEmpty())
                        <p class="text-gray-600">No se encontraron productos.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($resultados as $producto)
                                <div class="bg-white shadow-md rounded-lg p-4">
                                    <h3 class="text-base font-bold mb-1">{{ $producto->product_name }}</h3>
                                    <p class="text-gray-600 text-sm mb-1">
                                        # {{ $producto->aisle->aisle }} | Dept: {{ $producto->department->department }}
                                    </p>
                                    <p class="text-green-600 font-semibold text-sm mb-2">ID: {{ $producto->id }}</p>
                                    <form action="{{ route('cart.add', ['id' => $producto->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-blue-500 text-white text-sm py-1 rounded hover:bg-blue-600">
                                            Comprar
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if (!empty($sugerencias))
                        <div class="mt-6">
                            <h3 class="text-xl font-semibold mb-2">También te puede interesar</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($sugerencias as $sugerido)
                                    <div class="bg-white shadow-md rounded-lg p-4">
                                        <h4 class="text-base font-bold mb-1">{{ $sugerido->product_name }}</h4>
                                        <p class="text-gray-600 text-sm mb-1">
                                            # {{ $sugerido->aisle->aisle }} | Dept:
                                            {{ $sugerido->department->department }}
                                        </p>
                                        <p class="text-green-600 font-semibold text-sm mb-2">ID: {{ $sugerido->id }}
                                        </p>
                                        <button
                                            class="w-full bg-blue-500 text-white text-sm py-1 rounded hover:bg-blue-600">
                                            Comprar
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
                                <div
                                    class="swiper-slide bg-white shadow-md rounded-lg p-4 w-72 h-48 flex flex-col justify-between">
                                    <h3 class="text-base font-bold mb-1">{{ $producto->product_name }}</h3>
                                    <p class="text-gray-600 text-sm mb-1">
                                        # {{ $producto->aisle->aisle }} | Dept:
                                        {{ $producto->department->department }}
                                    </p>
                                    <p class="text-green-600 font-semibold text-sm mb-2">ID: {{ $producto->id }}</p>
                                    <button
                                        wire:click="addToCart({{ $producto->id }})"class="w-full bg-blue-500 text-white text-sm py-1 rounded hover:bg-blue-600">
                                        Comprar
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
                                # {{ $popular->aisle->aisle }} | Dept: {{ $popular->department->department }}
                            </p>
                            <p class="text-green-600 font-semibold text-sm mb-2">ID: {{ $popular->id }}</p>
                            <button
                                wire:click="addToCart({{ $popular->id }})"class="w-full bg-blue-500 text-white text-sm py-1 rounded hover:bg-blue-600">
                                Comprar
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

</div>
