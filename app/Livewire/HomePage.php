<?php

namespace App\Livewire;

use App\Models\Basket;
use App\Models\Product;
use App\Services\ApiService;
use Livewire\Component;

class HomePage extends Component
{


    public function render()
    {
        $service = new ApiService();
        $id = auth()->user()->id;

        // $recomendations = $service->getDataFromExternalApi($id);
        // $recommendations = Product::with(['aisle', 'department'])
        //     ->whereIn('product_id', $recomendations['recommendations'])
        //     ->get();

        $recommendationsFromApi  = $service->getDataFromExternalApi($id);
        // dd($recommendationsFromApi);
        $recommendations = collect();

        foreach ($recommendationsFromApi['recommendations'] as $aisleId) {
            $products = Product::with(['aisle', 'department'])
                ->where('aisle_id', $aisleId)
                ->inRandomOrder()
                ->take(5) // puedes ajustar cuántos productos aleatorios tomar por pasillo
                ->get();

            $recommendations = $recommendations->merge($products);
            // dd($recommendations);
        }

        // dd($recommendations);


        $populars = $service->getPopularProducts();
        // dd($populars);
        $popularProducts = Product::with(['aisle', 'department'])
            ->whereIn('id', $populars['recommendations'])
            ->get();


        return view('livewire.home-page', [
            'recommendations' => $recommendations,
            'populars' => $popularProducts
        ]);
    }

    public function index()
    {
        $productos = Product::with(['aisle', 'department'])->paginate(20); // todos los productos
        return view('products.all-products', ['productos' => $productos]);
    }

    public function addToCart($id)
    {
        // dd($id);

        $user = auth()->user();

        // Si el usuario no tiene cesta, la crea
        $basket = $user->basket ?? Basket::create(['user_id' => $user->id]);
        
        // Agrega el producto al basket (asumiendo belongsToMany con tabla intermedia)
        $basket->products()->attach($id);
        
        // Mostrar productos del basket
        dd($basket->products()->get());
    }
}
