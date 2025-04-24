<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        $view = $request->input('view', 'dashboard'); // ← Valor por defecto

        $vista = match ($view) {
            'dashboard' => 'dashboard',
            'productos' => 'all-products',
            'categorias' => 'categories.index',
            default => 'dashboard', // Fallback
        };

        $palabras = preg_split('/[\s,]+/', strtolower($query));

        // Obtener todos los productos (sin paginación para buscar en todos)
        $productos = Product::all(); 

        $resultados = $productos->filter(function ($producto) use ($palabras) {
            $nombreNormalizado = strtolower(Str::ascii($producto->product_name));
            foreach ($palabras as $palabra) {
                $palabra = strtolower(Str::ascii($palabra));
                $sinonimos = [
                    'soda' => ['soft drink', 'cola', 'drink'],
                    'meat' => ['beef', 'chicken', 'turkey', 'turkey'],
                    'snack' => ['snack', 'appetizer', 'snack'],
                    'tea' => ['tea', 'infusion'],
                ];
                $palabrasBuscar = [$palabra];
                foreach ($sinonimos as $key => $variantes) {
                    if ($palabra === $key || in_array($palabra, $variantes)) {
                        $palabrasBuscar = array_merge($palabrasBuscar, [$key], $variantes);
                    }
                }
                foreach ($palabrasBuscar as $p) {
                    if (str_contains($nombreNormalizado, $p)) {
                        return true;
                    }
                }
            }
            return false;
        });

        // Obtener sugerencias solo de los productos que coinciden
        $sugerencias = [];
        if ($resultados->isNotEmpty()) {
            $palabrasClave = $resultados->pluck('product_name')
                ->flatMap(function ($nombre) {
                    return explode(' ', strtolower(Str::ascii($nombre)));
                })
                ->filter(function ($palabra) use ($palabras) {
                    return strlen($palabra) > 3 && !in_array($palabra, $palabras);
                })
                ->map(function ($palabra) {
                    $diccionario = [
                        'soda' => ['soft drink', 'cola', 'drink'],
                        'meat' => ['beef', 'chicken', 'turkey', 'turkey'],
                        'snack' => ['snack', 'appetizer', 'snack'],
                        'tea' => ['tea', 'infusion'],
                        'dessert' => ['sweet', 'cake', 'chocolate'],
                    ];
                    foreach ($diccionario as $original => $variantes) {
                        if ($palabra === $original || in_array($palabra, $variantes)) {
                            return $original;
                        }
                    }
                    return $palabra;
                })
                ->unique()
                ->take(5)
                ->values()
                ->all();

            foreach ($palabrasClave as $clave) {
                foreach ($resultados as $producto) {
                    if (str_contains(strtolower($producto->product_name), $clave)) {
                        $sugerencias[] = $producto;
                    }
                }
            }

            // Eliminar duplicados por ID y tomar los primeros 5 resultados únicos
            $sugerencias = collect($sugerencias)->unique('id')->take(5)->values()->all();
        }

        // Mostrar los resultados de búsqueda en la vista correcta
        return view($vista, [
            'resultados' => $resultados,
            'sugerencias' => $sugerencias,
            'query' => $query,
            'recommendations' => collect(), // Para que no rompa el dashboard
            'populars' => collect()
        ]);
    }
}
