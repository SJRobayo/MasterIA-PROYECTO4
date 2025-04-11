public function buscar(Request $request)
{
    $query = strtolower($request->input('q'));
    $productos = $this->obtenerProductos();

    // Filtrar los productos que contienen la palabra buscada
    $resultados = array_filter($productos, function ($producto) use ($query) {
        return str_contains(strtolower($producto['nombre']), $query);
    });

    // Sugerencias básicas (otros productos con palabras relacionadas)
    $sugerencias = [];

    if (!empty($resultados)) {
        // Sacamos algunas palabras clave del resultado
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

        // Buscar productos que coincidan con esas palabras clave
        foreach ($palabrasClave as $clave) {
            foreach ($productos as $producto) {
                if (str_contains(strtolower($producto['nombre']), $clave)) {
                    $sugerencias[] = $producto;
                }
            }
        }

        // Limitar sugerencias a 5 distintas
        $sugerencias = collect($sugerencias)->unique('id')->take(5)->values()->all();
    }

    return view('productos.resultados', compact('resultados', 'sugerencias', 'query'));
}
