<?php

namespace App\Livewire;

use App\Models\Basket;
use App\Models\Product;
use App\Services\ApiService;
use Livewire\Component;

class HomePage extends Component
{

    public $cluster;

    public function render()
    {
        $product = Product::where('id', 15872)->first();
        // dd($product);
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


        $populars = $service->getPopularProducts($id);
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

        $basket = Basket::firstOrCreate(['user_id' => $user->id]);

        if (!$basket->products()->where('products.id', $id)->exists()) {
            $basket->products()->attach($id);
        }
        session()->flash('success', 'Producto añadido al carrito');
        return redirect()->back();
    }
}
