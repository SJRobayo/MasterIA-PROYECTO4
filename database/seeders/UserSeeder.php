<?php

namespace Database\Seeders;

use App\Models\User;
use Dotenv\Store\File\Reader;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\Csv\Reader as CsvReader;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = storage_path('app/public/csv/df_final.csv');

        if (!file_exists($filePath)) {
            die("El archivo CSV no existe.");
        }

        $csv = CsvReader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);

        $processedUserIds = [];

        foreach ($csv as $record) {
            $userId = (int) $record['user_id'];

            // Verificar si el user_id ya fue procesado
            if (in_array($userId, $processedUserIds)) {
                continue;
            }

            // Crear el usuario y agregar el user_id al array de procesados
            User::create([
                'id' => $userId,
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('password'), // Contraseña predeterminada
            ]);
            echo "Usuario creado: $userId\n";

            $processedUserIds[] = $userId;
        }

        echo "Importación de usuarios completada.\n";
    }
}
