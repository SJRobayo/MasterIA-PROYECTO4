<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    // Vista de todos los productos
    public function index()
    {
        // Obtener todos los productos desde la base de datos
        $productos = Product::paginate(20);
        return view('dashboard', compact('productos'));
    }

    // Búsqueda de productos
    public function buscar(Request $request)
    {
        // Obtener las palabras introducidas (como una cadena)
        $query = $request->input('q');
        
        // Convertir la cadena de palabras en un array, separando por comas o espacios
        $palabras = preg_split('/[\s,]+/', strtolower($query));
        
        // Obtener los productos filtrados desde la base de datos
        $productos = Product::paginate(20);  // Ahora obtenemos los productos directamente desde el modelo Product
        
        // Filtrar los productos que contienen alguna de las palabras clave
        $resultados = $productos->filter(function ($producto) use ($palabras) {
            foreach ($palabras as $palabra) {
                if (str_contains(strtolower($producto->product_name), $palabra)) {
                    return true; // Si alguna palabra se encuentra en el nombre del producto, incluirlo
                }
            }
            return false; // Si ninguna palabra se encuentra, descartar el producto
        });

        // Sugerencias básicas usando palabras clave relacionadas
        $sugerencias = [];

        if ($resultados->isNotEmpty()) {
            // Crear un conjunto de palabras clave relacionadas para sugerencias
            $palabrasClave = $resultados->pluck('product_name')
                ->flatMap(function ($nombre) {
                    return explode(' ', strtolower($nombre));
                })
                ->filter(function ($palabra) use ($palabras) {
                    return strlen($palabra) > 3 && !in_array($palabra, $palabras); // Excluir las palabras ya buscadas
                })
                ->unique()
                ->take(3)
                ->values()
                ->all();

            // Buscar productos relacionados con las palabras clave
            foreach ($palabrasClave as $clave) {
                foreach ($productos as $producto) {
                    if (str_contains(strtolower($producto->product_name), $clave)) {
                        $sugerencias[] = $producto;
                    }
                }
            }

            // Eliminar productos duplicados y limitar a 5 sugerencias
            $sugerencias = collect($sugerencias)->unique('id')->take(5)->values()->all();
        }

        // Retornar la vista con los resultados y sugerencias
        return view('productos.resultados', compact('resultados', 'sugerencias', 'query'));
    }
}