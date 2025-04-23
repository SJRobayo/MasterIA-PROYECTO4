<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Aisle;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = storage_path('app/public/csv/definitivo.csv');

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

            $fields = str_getcsv(trim($buffer));

            if (count($fields) === 14) {
                [
                    $order_id,
                    $product_id,
                    $add_to_cart_order,
                    $reordered,
                    $user_id,
                    $order_number,
                    $order_dow,
                    $order_hour_of_day,
                    $days_since_prior_order,
                    $product_name,
                    $aisle_id,
                    $department_id,
                    $aisle_name,
                    $department_name
                ] = $fields;

                // Validaciones básicas
                if (!is_numeric($product_id) || !is_numeric($aisle_id) || !is_numeric($department_id)) {
                    echo "⚠️ Tipos inválidos en fila: " . json_encode($fields) . "\n";
                    $errores++;
                    $buffer = '';
                    continue;
                }

                try {
                    // Crear o encontrar aisle
                    Aisle::firstOrCreate(
                        ['id' => $aisle_id],
                        ['aisle' => $aisle_name]
                    );

                    // Crear o encontrar department
                    Department::firstOrCreate(
                        ['id' => $department_id],
                        ['department' => $department_name]
                    );

                    // Crear producto si no existe
                    Product::firstOrCreate(
                        ['product_id' => $product_id],
                        [
                            'product_name' => $product_name,
                            'aisle_id' => $aisle_id,
                            'department_id' => $department_id,
                        ]
                    );

                    $saved++;
                    echo "✅ Producto insertado: $product_id\n";
                } catch (\Throwable $e) {
                    echo "❌ Error en producto $product_id: " . $e->getMessage() . "\n";
                    $errores++;
                }

                // Limpiar buffer y contador
                $buffer = '';
                $incompleteCount = 0;
                $rowCount++;
            } else {
                $incompleteCount++;

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
        echo "📄 Total filas procesadas: $rowCount\n";
    }
}
