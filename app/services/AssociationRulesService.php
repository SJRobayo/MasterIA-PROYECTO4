<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;

class AssociationRulesService
{
    protected array $rules = [];

    public function __construct()
{
    $path = storage_path('app/reglas_asociacion.csv');
    if (!file_exists($path)) return;

    $file = fopen($path, 'r');
    $header = fgetcsv($file); // Leer encabezado

    while (($row = fgetcsv($file)) !== false) {
        $antecedentesRaw = $this->parseItem($row[0]);
        $consecuentesRaw = $this->parseItem($row[1]);

        foreach ($antecedentesRaw as $item) {
            $item = strtolower(trim(str_replace(' ', '', $item))); // Quitar espacios
            if (!isset($this->rules[$item])) {
                $this->rules[$item] = [];
            }
            foreach ($consecuentesRaw as $consecuente) {
                $this->rules[$item][] = strtolower(trim(str_replace(' ', '', $consecuente)));
            }
        }
    }

    // Limpiar duplicados
    foreach ($this->rules as $key => $valores) {
        $this->rules[$key] = array_unique($valores);
    }
}

// Función para limpiar frozenset
protected function parseItem($text): array
{
    if (str_starts_with($text, 'frozenset')) {
        $text = str_replace(['frozenset({', '})'], '', $text); // quitar frozenset({...})
        $text = str_replace("'", '', $text); // quitar comillas simples
    }

    $items = explode(',', $text);

    return array_map('trim', $items); // devolver los ítems limpios
}


    public function getConsequentsFor(string $keyword): array
    {
        $keyword = strtolower(str_replace(' ', '', $keyword));
        return $this->rules[$keyword] ?? [];
    }
}
