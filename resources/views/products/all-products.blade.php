<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">PRODUCTS</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mt-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">All Products</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
                    @foreach ($productos as $producto)
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

                <div class="mt-6">
                    {{ $productos->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
