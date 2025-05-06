<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🛒 Tu carrito de compras
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 bg-white p-6 shadow rounded-lg">
            @if ($basket && $basket->products->count())
                <h3 class="text-lg font-bold mb-4">Productos en tu carrito:</h3>
                <ul class="space-y-4">
                    @foreach ($basket->products as $product)
                        <li class="border-b pb-3">
                            <div class="text-base font-semibold">{{ $product->product_name }}</div>
                            <div class="text-sm text-gray-500">
                                Aisle: {{ $product->aisle->aisle ?? '-' }} | Department:
                                {{ $product->department->department ?? '-' }}
                            </div>
                            <div class="text-sm text-green-600">ID: {{ $product->id }}</div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-600">Tu carrito está vacío.</p>
            @endif
        </div>
    </div>

    <div class="mt-8">
        
        <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">People also buy</h2>

        <div class="flex justify-center">
            <div class="swiper mySwiper select-none max-w-6xl">
                <div class="swiper-wrapper">
                    @foreach (range(1, 3) as $repeat)
                        @foreach ($mbaProducts as $producto)
                            <div
                                class="swiper-slide bg-white shadow-md rounded-lg p-4 w-72 h-48 flex flex-col justify-between">
                                <h3 class="text-base font-bold mb-1">{{ $producto->product_name }}</h3>
                                <p class="text-gray-600 text-sm mb-1">
                                    # {{ $producto->aisle->aisle }} | Dept: {{ $producto->department->department }}
                                </p>
                                <p class="text-green-600 font-semibold text-sm mb-2">ID: {{ $producto->id }}</p>
                                <button wire:click="addToCart({{ $producto->id }})"
                                    class="w-full bg-blue-500 text-white text-sm py-1 rounded hover:bg-blue-600">
                                    Comprar
                                </button>
                            </div>
                        @endforeach
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
</div>
