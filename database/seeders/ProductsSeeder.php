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

        while (($line = fgets($handle)) !== false) {
            $buffer .= $line;

            $fields = str_getcsv(trim($buffer));

            if (count($fields) === 4) {
                [$product_id, $product_name, $department_id, $aisle_id] = $fields;

                if (
                    is_numeric($product_id) &&
                    is_numeric($department_id) &&
                    is_numeric($aisle_id)
                ) {
                    Product::create([
                        'product_id' => (int) $product_id,
                        'product_name' => $product_name,
                        'department_id' => (int) $department_id,
                        'aisle_id' => (int) $aisle_id,
                    ]);
                    $saved++;
                    echo "✅ Producto insertado: $product_id\n";
                } else {
                    dump("⚠️ Campos no válidos (tipos):", $fields);
                    $errores++;
                }

                $buffer = ''; // Reiniciamos el buffer para la siguiente línea
                $rowCount++;
            } else {
                // Seguimos acumulando hasta tener una línea bien formada
                continue;
            }
        }

        fclose($handle);

        echo "✅ Productos insertados: $saved\n";
        echo "⚠️ Filas problemáticas: $errores\n";
        echo "📄 Total procesado: $rowCount\n";
    }
}
