<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductosController extends Controller
{
    // Vista de todos los productos
    public function index()
    {
        $productos = $this->obtenerProductos();
        return view('dashboard', compact('productos')); // Asegúrate que la vista se llame 'dashboard.blade.php'
    }

    // Búsqueda de productos
    public function buscar(Request $request)
    {
        $query = strtolower($request->input('q'));
        $productos = $this->obtenerProductos();

        // Filtrar los productos que contienen la palabra buscada
        $resultados = array_filter($productos, function ($producto) use ($query) {
            return str_contains(strtolower($producto['nombre']), $query);
        });

        // Sugerencias básicas usando palabras clave relacionadas
        $sugerencias = [];

        if (!empty($resultados)) {
            $palabrasClave = collect($resultados)
                ->pluck('nombre')
                ->flatMap(function ($nombre) {
                    return explode(' ', strtolower($nombre));
                })
                ->filter(function ($palabra) use ($query) {
                    return strlen($palabra) > 3 && !str_contains($palabra, $query);
                })
                ->unique()
                ->take(3)
                ->values()
                ->all();

            foreach ($palabrasClave as $clave) {
                foreach ($productos as $producto) {
                    if (str_contains(strtolower($producto['nombre']), $clave)) {
                        $sugerencias[] = $producto;
                    }
                }
            }

            $sugerencias = collect($sugerencias)->unique('id')->take(5)->values()->all();
        }

        return view('productos.resultados', compact('resultados', 'sugerencias', 'query'));
    }

    // Método auxiliar para obtener productos
    private function obtenerProductos()
    {
        return [
            ['id' => 1, 'nombre' => 'Chocolate Sandwich Cookies', 'aisle_id' => 61, 'department_id' => 19],
            ['id' => 2, 'nombre' => 'All-Seasons Salt', 'aisle_id' => 104, 'department_id' => 13],
            ['id' => 3, 'nombre' => 'Robust Golden Unsweetened Oolong Tea', 'aisle_id' => 94, 'department_id' => 7],
            ['id' => 4, 'nombre' => 'Smart Ones Classic Favorites Mini Rigatoni With Vodka Cream Sauce', 'aisle_id' => 38, 'department_id' => 1],
            ['id' => 5, 'nombre' => 'Green Chile Anytime Sauce', 'aisle_id' => 5, 'department_id' => 13],
            ['id' => 6, 'nombre' => 'Dry Nose Oil', 'aisle_id' => 11, 'department_id' => 11],
            ['id' => 7, 'nombre' => 'Pure Coconut Water With Orange', 'aisle_id' => 98, 'department_id' => 7],
            ['id' => 8, 'nombre' => 'Cut Russet Potatoes Steam N\' Mash', 'aisle_id' => 116, 'department_id' => 1],
            ['id' => 9, 'nombre' => 'Light Strawberry Blueberry Yogurt', 'aisle_id' => 120, 'department_id' => 16],
            ['id' => 10, 'nombre' => 'Sparkling Orange Juice & Prickly Pear Beverage', 'aisle_id' => 115, 'department_id' => 7],
            ['id' => 11, 'nombre' => 'Peach Mango Juice', 'aisle_id' => 31, 'department_id' => 7],
            ['id' => 12, 'nombre' => 'Chocolate Fudge Layer Cake', 'aisle_id' => 119, 'department_id' => 1],
            ['id' => 13, 'nombre' => 'Saline Nasal Mist', 'aisle_id' => 11, 'department_id' => 11],
            ['id' => 14, 'nombre' => 'Fresh Scent Dishwasher Cleaner', 'aisle_id' => 74, 'department_id' => 17],
            ['id' => 15, 'nombre' => 'Overnight Diapers Size 6', 'aisle_id' => 56, 'department_id' => 18],
            ['id' => 16, 'nombre' => 'Mint Chocolate Flavored Syrup', 'aisle_id' => 103, 'department_id' => 19],
            ['id' => 17, 'nombre' => 'Rendered Duck Fat', 'aisle_id' => 35, 'department_id' => 12],
            ['id' => 18, 'nombre' => 'Pizza for One Suprema  Frozen Pizza', 'aisle_id' => 79, 'department_id' => 1],
            ['id' => 19, 'nombre' => 'Gluten Free Quinoa Three Cheese & Mushroom Blend', 'aisle_id' => 63, 'department_id' => 9],
            ['id' => 20, 'nombre' => 'Pomegranate Cranberry & Aloe Vera Enrich Drink', 'aisle_id' => 98, 'department_id' => 7],
            ['id' => 21, 'nombre' => 'Small & Medium Dental Dog Treats', 'aisle_id' => 40, 'department_id' => 8],
            ['id' => 22, 'nombre' => 'Fresh Breath Oral Rinse Mild Mint', 'aisle_id' => 20, 'department_id' => 11],
            ['id' => 23, 'nombre' => 'Organic Turkey Burgers', 'aisle_id' => 49, 'department_id' => 12],
            ['id' => 24, 'nombre' => 'Tri-Vi-Sol® Vitamins A-C-and D Supplement Drops for Infants', 'aisle_id' => 47, 'department_id' => 11],
            ['id' => 25, 'nombre' => 'Salted Caramel Lean Protein & Fiber Bar', 'aisle_id' => 3, 'department_id' => 19],
            ['id' => 26, 'nombre' => 'Fancy Feast Trout Feast Flaked Wet Cat Food', 'aisle_id' => 41, 'department_id' => 8],
            ['id' => 27, 'nombre' => 'Complete Spring Water Foaming Antibacterial Hand Wash', 'aisle_id' => 127, 'department_id' => 11],
            ['id' => 28, 'nombre' => 'Wheat Chex Cereal', 'aisle_id' => 121, 'department_id' => 14],
            ['id' => 29, 'nombre' => 'Fresh Cut Golden Sweet No Salt Added Whole Kernel Corn', 'aisle_id' => 81, 'department_id' => 15],
            ['id' => 30, 'nombre' => 'Producto Extra de Prueba', 'aisle_id' => 50, 'department_id' => 10], // ejemplo extra    
        ];
    }
}