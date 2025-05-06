<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    public function getDataFromExternalApi($userId)
    {
        $response = Http::get('https://instacartapi.onrender.com/recommend/' . $userId);
        // dd($response->json());
        if ($response->successful()) {
            return $response->json(); // o ->body() si prefieres el texto sin parsear
        }

        // Manejo de errores
        return [
            'error' => true,
            'message' => 'Error al conectar con la API externa',
            'status' => $response->status()
        ];
    }

    public function getPopularProducts()
    {
        $response = Http::get('http://127.0.0.1:8000/popular_products_model');

        if ($response->successful()) {
            return $response->json(); // o ->body() si prefieres el texto sin parsear
        }

        // Manejo de errores
        return [
            'error' => true,
            'message' => 'Error al conectar con la API externa',
            'status' => $response->status()
        ];
    }

    public function getMbaRecommendations(array $aisleIds, int $n = 5)
    {
        $response = Http::post('http://127.0.0.1:8000/basket/recommend', [
            'aisle_ids' => $aisleIds,
            'n' => $n
        ]);

        if ($response->successful()) {
            // dd($response->json());
            return $response->json();
        }

        return [
            'error' => true,
            'message' => 'Error al conectar con la API de MBA',
            'status' => $response->status()
        ];
    }
}
