<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = storage_path('app/public/csv/products.csv');

        if (!file_exists($filePath)) {
            die("❌ El archivo CSV no existe.");
        }

        $handle = fopen($filePath, 'r');
        $headers = fgetcsv($handle); 
        $buffer = '';
        $rowCount = 0;
        $saved = 0;
        $errores = 0;
        $incompleteCount = 0;

        while (($line = fgets($handle)) !== false) {
            $buffer .= $line;

            // Usamos str_getcsv para convertir el buffer en array
            $fields = str_getcsv(trim($buffer));

            if (count($fields) === 4) {
                [$product_id, $product_name, $department_id, $aisle_id] = $fields;

                if (
                    is_numeric($product_id) &&
                    is_numeric($department_id) &&
                    is_numeric($aisle_id)
                ) {
                    try {
                        Product::create([
                            'product_id' => (int) $product_id,
                            'product_name' => $product_name,
                            'department_id' => (int) $department_id,
                            'aisle_id' => (int) $aisle_id,
                        ]);
                        $saved++;
                        echo "✅ Insertado: $product_id\n";
                    } catch (\Throwable $e) {
                        echo "❌ Error al guardar $product_id: " . $e->getMessage() . "\n";
                        $errores++;
                    }
                } else {
                    echo "⚠️ Tipos inválidos en fila: " . json_encode($fields) . "\n";
                    $errores++;
                }

                // Reiniciamos
                $buffer = '';
                $incompleteCount = 0;
                $rowCount++;
            } else {
                $incompleteCount++;

                // Si hemos acumulado demasiadas líneas sin éxito, la descartamos
                if ($incompleteCount >= 10 || strlen($buffer) > 20000) {
                    echo "🚨 Línea descartada por ser demasiado larga o incompleta:\n$buffer\n";
                    $buffer = '';
                    $errores++;
                    $incompleteCount = 0;
                }

                continue;
            }
        }

        fclose($handle);

        echo "\n📊 RESUMEN:\n";
        echo "✅ Productos insertados: $saved\n";
        echo "⚠️ Filas problemáticas: $errores\n";
        echo "📄 Total filas leídas: $rowCount\n";
    }
}
