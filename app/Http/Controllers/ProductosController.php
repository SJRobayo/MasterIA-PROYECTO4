<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ApiService;
use Illuminate\Support\Str;

class ProductosController extends Controller
{

    public $recommendations;
    public $populars;
    // Vista de todos los productos
    public function dashboard()
    {
        $service = new ApiService();
        $id = auth()->user()->id;

        // $recomendations = $service->getDataFromExternalApi($id);
        // $recommendations = Product::with(['aisle', 'department'])
        //     ->whereIn('product_id', $recomendations['recommendations'])
        //     ->get();

        $recommendationsFromApi  = $service->getDataFromExternalApi($id);

        $recommendations = collect();

        foreach ($recommendationsFromApi['recommendations'] as $aisleId) {
            $products = Product::with(['aisle', 'department'])
                ->where('aisle_id', $aisleId)
                ->inRandomOrder()
                ->take(5) // puedes ajustar cuántos productos aleatorios tomar por pasillo
                ->get();

            $recommendations = $recommendations->merge($products);
        }

        // dd($recommendations);


        $populars = $service->getPopularProducts();
        $popularProducts = Product::with(['aisle', 'department'])
            ->whereIn('id', $populars['recommendations'])
            ->get();


        return view('dashboard', [
            'recommendations' => $recommendations,
            'populars' => $popularProducts
        ]);
    }

    public function index()
    {
        $productos = Product::with(['aisle', 'department'])->paginate(20); // todos los productos
        return view('products.all-products', ['productos' => $productos]);
    }
}
