<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\ApiService;
use App\Services\AssociationRulesService;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        $view = $request->input('view', 'dashboard');

        $vista = match ($view) {
            'dashboard' => 'dashboard',
            'productos' => 'all-products',
            'categorias' => 'categories.index',
            default => 'dashboard',
        };

        $palabras = preg_split('/[\s,]+/', strtolower($query));
        $palabras = array_map(fn($p) => strtolower(Str::ascii($p)), $palabras);

        $userId = auth()->user()->id;
        $service = new ApiService();
        $recomendaciones = $service->getDataFromExternalApi($userId);

        $productos = Product::with(['aisle', 'department'])->get();
        $productosRecomendados = Product::whereIn('product_id', $recomendaciones['recommendations'])
            ->with(['aisle', 'department'])
            ->get();

        $resultados = $productos->filter(function ($producto) use ($palabras) {
            $nombre = strtolower(Str::ascii($producto->product_name));
            return collect($palabras)->contains(fn($palabra) => str_contains($nombre, $palabra));
        });

        $resultadosRecomendados = $productosRecomendados->filter(function ($producto) use ($palabras) {
            $nombre = strtolower(Str::ascii($producto->product_name));
            return collect($palabras)->contains(fn($palabra) => str_contains($nombre, $palabra));
        });

        // ------- AQUÍ empieza lo importante (recomendaciones) -------
        $associationService = new AssociationRulesService();
        $recomendados = collect();

        if ($resultados->isNotEmpty()) {
            $aisleDeps = $resultados->map(function ($producto) {
                $aisle = strtolower(str_replace(' ', '', Str::ascii($producto->aisle->aisle_name)));
                $department = strtolower(str_replace(' ', '', Str::ascii($producto->department->department_name)));
                return $aisle . '|' . $department;
            })->unique(); // Evitamos duplicados

            $consecuentesTotales = collect();

            foreach ($aisleDeps as $aisleDep) {
                $consecuentes = $associationService->getConsequentsFor($aisleDep);
                $consecuentesTotales = $consecuentesTotales->merge($consecuentes);
            }

            $consecuentesTotales = $consecuentesTotales->unique();

            foreach ($consecuentesTotales as $asociado) {
                if (strpos($asociado, '|') !== false) {
                    [$aisleConsequent, $deptConsequent] = explode('|', $asociado);

                    $matches = Product::with(['aisle', 'department'])
                        ->get()
                        ->filter(function ($producto) use ($aisleConsequent, $deptConsequent) {
                            $aisle = strtolower(str_replace(' ', '', Str::ascii($producto->aisle->aisle_name)));
                            $department = strtolower(str_replace(' ', '', Str::ascii($producto->department->department_name)));

                            return $aisle === $aisleConsequent && $department === $deptConsequent;
                        });

                    $recomendados = $recomendados->merge($matches);
                }
            }
        }

        $recomendados = $recomendados->unique('id')->take(5)->values();


        return view($vista, [
            'resultados' => $resultados,
            'resultadosRecomendados' => $resultadosRecomendados,
            'sugerencias' => $recomendados,
            'query' => $query,
            'recommendations' => collect(),
            'populars' => collect()
        ]);
    }
}
