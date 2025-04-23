<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    public function getDataFromExternalApi($userId)
    {
        $response = Http::get('https://instacartapi.onrender.com/recommend/' . $userId);

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
        $response = Http::get('https://instacartapi.onrender.com/popular_products_model');

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
}
