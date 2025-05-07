<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Services\ApiService;

class CartPage extends Component
{
    public $basket;
    public $mbaRecommendations = [];
    public $mbaProducts;

    public function mount(ApiService $api)
    {
        $user = auth()->user();
        $this->basket = $user->cart()->with('products.aisle')->first();

        if ($this->basket && $this->basket->products->count()) {
            // Extraer los aisle_ids del carrito
            $aisleIds = $this->basket->products->pluck('aisle_id')->unique()->values()->toArray();

            $result = $api->getMbaRecommendations($aisleIds);

            if (!isset($result['error'])) {
                $this->mbaRecommendations = $result['recommendations'];
            }
        }
        
        // dd($this->mbaRecommendations);

        foreach ($this->mbaRecommendations as $aisleId) {
            $product = Product::where('aisle_id', $aisleId)->inRandomOrder()->first();
        
            if ($product) {
                $this->mbaProducts[] = $product;
            }
        }

        if (empty($this->mbaProducts)) {
            $this->mbaProducts = [];
        }

        // dd($this->mbaProducts);
    }

    public function render()
    {
        return view('livewire.cart-page')->layout('layouts.app');
    }
}
